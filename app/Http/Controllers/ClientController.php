<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Staff;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 8)){
            if ($request->ajax()) {
                $data = Client::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('projects', function($row){
                        $project_name = '';
                        for ($i = 0 ; $i < count($row->projects) ; $i++) {
                            $project = Project::where('id', $row->projects[$i])->first();
                            $project_name = '<b>'. $project_name . $project->project_name .'</b><br>';
                        }
                        return $project_name;
                    })
                    ->addColumn('staff', function($row){
                        $staff = Staff::where('id', $row->staff_id)->first();
                        return $staff->name;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.client.edit', $row->id);
                        $deleteurl = route('admin.client.destroy', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                               <form action='$deleteurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='DELETE' />
                                   <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                               </form>
                               ";

                                return $btn;
                    })
                    ->rawColumns(['projects', 'staff', 'action'])
                    ->make(true);
            }
            return view('backend.client.index');
        }
        else{
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
        if(checkpermission(Auth::user()->role_id, 9)){
            $projects = Project::get();
            $staffs = Staff::where('status', 1)->get();
            return view('backend.client.create', compact('projects', 'staffs'));
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
        // dd($request['staff_id']);
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'projects' => 'required',
            'staff_id' => 'required',
        ]);

        $client = Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'projects' => $data['projects'],
            'staff_id' => $data['staff_id'],
        ]);

        $client->save();

        return redirect()->route('admin.client.index')->with('success', 'Client information added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(checkpermission(Auth::user()->role_id, 9)){
            $client = Client::findorFail($id);
            $projects = Project::get();
            $staffs = Staff::where('status', 1)->get();
            return view('backend.client.edit', compact('staffs', 'client', 'projects'));
        }
        else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::findorFail($id);
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'projects' => 'required',
            'staff_id' => 'required'
        ]);

        $client->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'projects' => $data['projects'],
            'staff_id' => $data['staff_id'],
        ]);
        return redirect()->route('admin.client.index')->with('success', 'Client information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(checkpermission(Auth::user()->role_id, 9)){
            $client = Client::findorFail($id);
            $client->delete();
            return redirect()->route('admin.client.index')->with('success', 'Client Information deleted successfully.');
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }
}
