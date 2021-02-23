<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectImages;
use App\Models\Staff;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 10)){
            if ($request->ajax()) {
                $data = Project::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('staff', function($row){
                        $name = '';
                        for ($i = 0 ; $i < count($row->completed_by) ; $i++) {
                            $staff = Staff::where('id', $row->completed_by[$i])->first();
                            $name = $name . $staff->name .'<br>';
                        }
                        return $name;
                    })
                    ->addColumn('started_date', function($row){
                        $started_date = date('F j, Y', strtotime($row->started_date));
                        return $started_date;
                    })
                    ->addColumn('completed_date', function($row){
                        $completed_date = date('F j, Y', strtotime($row->completed_date));
                        return $completed_date;
                    })
                    ->addColumn('category', function($row){
                        $category = $row->category->name;
                        return $category;
                    })
                    ->addColumn('price', function($row){
                        $price = '';
                        if ($row->price == null) {
                            $price = 'Project ongoing';
                        }else{
                            $price = 'Rs. '.$row->price;
                        }
                        return $price;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.project.edit', $row->id);
                        $showurl = route('admin.project.show', $row->id);
                        $deleteurl = route('admin.project.destroy', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "<a href='$showurl' class='edit btn btn-info btn-sm'>Show</a>
                                <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                               <form action='$deleteurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='DELETE' />
                                   <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                               </form>
                               ";

                                return $btn;
                    })
                    ->rawColumns(['staff', 'started_date', 'completed_date', 'category', 'price',  'action'])
                    ->make(true);
            }
            return view('backend.projects.index');
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(checkpermission(Auth::user()->role_id, 11)){
            $category = Category::latest()->get();
            $staff = Staff::latest()->where('position_id', '!=', 11)->get();
            return view('backend.projects.create', compact('staff', 'category'));
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request['slider']);
        $data = $this->validate($request, [
            'project_name' => 'required',
            'completed_by' => 'required',
            'started_date' => '',
            'completed_date' => '',
            'description' => '',
            'slider' => '',
            'screenshots' =>'required',
            'screenshots.*' => 'mimes:jpg,jpeg,png',
            'price' => '',
            'category' => 'required'
        ]);

        $projectstate = '';
        if($request['slider'] == null)
        {
            $projectstate = 'On Process';
        }
        elseif($request['slider'] == 1)
        {
            $projectstate = 'Completed';
        }

        $project = Project::create([
            'project_name' => $data['project_name'],
            'completed_by' => $data['completed_by'],
            'started_date' => $data['started_date'],
            'completed_date' => $data['completed_date'],
            'description' => $data['description'],
            'state' => $projectstate,
            'price' => $request['price'],
            'category_id' => $request['category'],
        ]);
        $imagename = '';
        if($request->hasfile('screenshots')){
            $images = $request->file('screenshots');
            foreach($images as $image){
                $imagename = $image->store('project_screenshots', 'uploads');

                $projectimage = ProjectImages::create([
                    'project_id' => $project['id'],
                    'screenshots' => $imagename,
                ]);
                $projectimage->save();
            }
        }

        $project->save();

        return redirect()->route('admin.project.index')->with('success', 'Project Information saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findorFail($id);
        $projectimages = ProjectImages::where('project_id', $project->id)->get();

        return view('backend.projects.show', compact('project', 'projectimages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findorFail($id);
        $staff = Staff::latest()->where('position_id', '!=', 11)->get();
        $category = Category::latest()->get();
        return view('backend.projects.edit', compact('project', 'staff', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findorFail($id);
        $projectimages = ProjectImages::where('project_id', $project->id)->get();
        $data = $this->validate($request, [
            'project_name' => 'required',
            'completed_by' => 'required',
            'started_date' => 'required',
            'completed_date' => '',
            'description' => '',
            'state'  => '',
            'screenshots' => '',
            'screenshots.*' => 'mimes:jpg,jpeg,png',
            'price' => '',
            'category' => 'required'
        ]);

        $projectstate = '';
        if($request['slider'] == null)
        {
            $projectstate = 'On Process';
        }
        elseif($request['slider'] == 1)
        {
            $projectstate = 'Completed';
        }

        $project->update([
            'project_name' => $data['project_name'],
            'completed_by' => $data['completed_by'],
            'started_date' => $data['started_date'],
            'completed_date' => $data['completed_date'],
            'description' => $data['description'],
            'state' => $projectstate,
            'price' => $request['price'],
            'category_id' => $request['category'],
        ]);

        $imagename = '';
        if($request->hasfile('screenshots')){
            foreach ($projectimages as $image) {
                Storage::disk('uploads')->delete($image->screenshots);
                $image->delete();
            }

            $images = $request->file('screenshots');
            foreach($images as $image){
                $imagename = $image->store('project_screenshots', 'uploads');

                $projectimage = ProjectImages::create([
                    'project_id' => $project['id'],
                    'screenshots' => $imagename,
                ]);
                $projectimage->save();
            }
        }
        return redirect()->route('admin.project.index')->with('success', 'Project Information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findorFail($id);

        $clients =Client::latest()->get();

        foreach ($clients as $client) {
            if (in_array($project->id, $client->projects)) {
                return redirect()->back()->with('failure', 'Clients are involved in project. Cannot delete.');
            }
        }
        $projectimages = ProjectImages::where('project_id', $project->id)->get();
        foreach ($projectimages as $image) {
            Storage::disk('uploads')->delete($image->screenshots);
            $image->delete();
        }
        $project->delete();

        return redirect()->back()->with('success', 'Project Deleted successfully.');
    }
}
