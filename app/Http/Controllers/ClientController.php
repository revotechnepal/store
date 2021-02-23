<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
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
                            $project_name = $project_name . $project->project_name .'<br>';
                        }
                        return $project_name;
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
                    ->rawColumns(['projects', 'action'])
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
            return view('backend.client.create', compact('projects'));
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
        // dd($request['projects']);
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'projects' => 'required'
        ]);

        $client = Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'projects' => $data['projects'],
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
            return view('backend.client.edit', compact('client', 'projects'));
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
        ]);

        $client->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'projects' => $data['projects'],
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
