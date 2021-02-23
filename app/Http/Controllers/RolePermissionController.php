<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 16)){
            if ($request->ajax()) {
                $data = RolePermission::latest()->with('getrolename')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('rolename', function ($row) {
                        $rolename = $row->getrolename->name;
                        return $rolename;
                    })
                    ->addColumn('allpermissions', function ($row) {
                        $permissions = $row->permission_id;
                        $allpermissions = '';
                        foreach ($permissions as $permission) {
                            $permission_name = Permission::where('id', $permission)->first();
                            $allpermissions .= '<span class="badge bg-green">' . $permission_name->permissions . '</span>' . ' ';
                        }
                        return $allpermissions;
                    })
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('F j, Y', strtotime($row->created_at));
                        return $created_at;
                    })
                    ->addColumn('action', function ($row) {
                        $editurl = route('admin.rolepermission.edit', $row->id);
                        $deleteurl = route('admin.rolepermission.destroy', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                            </form>";
                        return $btn;
                    })
                    ->rawColumns(['rolename', 'allpermissions', 'created_at', 'action'])
                    ->make(true);
            }
            return view('backend.rolespermissions.index');
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
        if(checkpermission(Auth::user()->role_id, 16)){
            $roles = Role::latest()->get();
            return view('backend.rolespermissions.create', compact('roles'));
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
            'role' => 'required'
        ]);
        $role_id = $data['role'];
        $permissionexists = RolePermission::where('role_id', $role_id)->first();
        if ($permissionexists) {
            return redirect()->back()->with('failure', 'Permissions for Role already added, please edit.');
        } else {
            if ($request['permission'] == null) {
                return redirect()->back()->with('failure', 'Permission cannot be null');
            } else {
                $permissions = $request['permission'];
            }
            $rolepermission = RolePermission::create([
                'role_id' => $role_id,
                'permission_id' => $permissions,
            ]);
            $rolepermission->save();
            return redirect()->route('admin.rolepermission.index')->with('success', 'Role and Permissions added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function show(RolePermission $rolePermission)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolepermission = RolePermission::findorFail($id);;
        $role = Role::where('id', $rolepermission->role_id)->first();
        return view('backend.rolespermissions.edit', compact('rolepermission', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rolepermission = RolePermission::where('id', $id)->first();
        if ($request['permission'] == null) {
            return redirect()->back()->with('failure', 'Permission cannot be null');
        } else {
            $permissions = $request['permission'];
        }
        $rolepermission->update([
            'permission_id' => $permissions,
        ]);
        $rolepermission->save();
        return redirect()->route('admin.rolepermission.index')->with('success', 'Role and Permissions updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RolePermission  $rolePermission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = RolePermission::where('id', $id)->first();
        $permission->delete();
        return redirect()->back()->with('success', 'Permissions Deleted');
    }
}
