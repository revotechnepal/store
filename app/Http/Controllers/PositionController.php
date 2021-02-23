<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 3)){
            if ($request->ajax()) {
                $data = Position::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $editurl = route('admin.position.edit', $row->id);
                        $disableurl = route('admin.position.disable', $row->id);
                        $enableurl = route('admin.position.enable', $row->id);
                        $csrf_token = csrf_token();
                        if ($row->status == 0) {
                            $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                                <form action='$enableurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='PUT' />
                                    <button type='submit' class='btn btn-success btn-sm'>Enable</button>
                                </form>
                                ";
                        } else {
                            $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                                <form action='$disableurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='PUT' />
                                    <button type='submit' class='btn btn-danger btn-sm'>Disable</button>
                                </form>
                                ";
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('backend.positions.index');
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
        if(checkpermission(Auth::user()->role_id, 3))
        {
            return view('backend.positions.create');
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
        $data = $this->validate($request, [
            'name' => 'required',
            'make_role' => 'required|boolean'
        ]);

        $positionexist = Position::where('name', $request['name'])->first();

        if($positionexist)
        {
            return redirect()->back()->with('danger', 'Position already exists.');
        }
        else
        {
            $position = Position::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'make_role' => $data['make_role'],
                'status' => 1
            ]);

            if($request['make_role'] == 1)
            {
                $role = Role::create([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                ]);

                $role->save();
            }

            $position->save();
            return redirect()->route('admin.position.index')->with('success', 'New Position added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::findorFail($id);
        return view('backend.positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'make_role' => 'required'
        ]);
        $position = Position::findorFail($id);

        if ($data['make_role'] == 1) {
            $role = Role::where('slug', $position->slug)->first();
            if($role)
            {
                $role->update([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name'])
                ]);
            }
            else
            {
                $role = Role::create([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name'])
                ]);
                $role->save();
            }
            $position->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'make_role' => 1
            ]);
        }
        else
        {
            $role = Role::where('slug', $position->slug)->first();
            $role->delete();
            $position->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'make_role' => 0
            ]);
        }
        return redirect()->route('admin.position.index')->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position = Position::findorFail($id);
        $staff = Staff::where('position_id', $position->id)->get();
        if($staff)
        {
            return redirect()->route('admin.position.index')->with('danger', 'Position used in staff. Cannot delete.');
        }
        else
        {
            $position->delete();
            return redirect()->route('admin.position.index')->with('success', 'Position deleted successfully.');
        }
    }

    public function disableposition($id)
    {
        $position = Position::findorfail($id);
        $position->update([
            'status' => '0',
        ]);
        //$staff->save();
        return redirect()->route('admin.position.index')->with('success', 'Position Disabled Successfully.');

    }

    public function enableposition($id)
    {
        $position = Position::findorfail($id);
        $position->update([
            'status' => '1',
        ]);
        //$staff->save();
        return redirect()->route('admin.position.index')->with('success', 'Position Enabled Successfully.');

    }
}
