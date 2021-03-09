<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Position;
use App\Models\Project;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 4)){
            if ($request->ajax()) {
                $data = Staff::latest()->with('position')->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $src = Storage::disk('uploads')->url($row->image);
                        $image = "<img src='$src' style='max-height: 100px;'>";
                        return $image;
                    })
                    ->addColumn('position', function($row){
                        $position = $row->position->name;
                        return $position;
                    })
                    ->addColumn('allocated_salary', function($row){
                        if($row->allocated_salary == 0){
                            $salary = '-';
                        }else {
                            $salary = 'Rs. '.$row->allocated_salary;
                        }
                        return $salary;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.staff.edit', $row->id);
                        $showurl = route('admin.staff.show', $row->id);
                        $disableurl = route('admin.staff.disable', $row->id);
                        $enableurl = route('admin.staff.enable', $row->id);
                        // $deleteurl = route('admin.staff.destroy', $row->id);
                        $csrf_token = csrf_token();


                        if ($row->status == 0) {
                            $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <a href='$showurl' class='show btn btn-info btn-sm'>Show</a>
                                <form action='$enableurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='PUT' />
                                    <button type='submit' class='btn btn-success btn-sm'>Enable</button>
                                </form>
                                ";
                        } else {
                            $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                            <a href='$showurl' class='show btn btn-info btn-sm'>Show</a>
                                <form action='$disableurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='PUT' />
                                    <button type='submit' class='btn btn-danger btn-sm'>Disable</button>
                                </form>
                                ";
                        }
                        // $btn = "<a href='$showurl' class='show btn btn-info btn-sm'>Show</a>
                        //         <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                        //        <form action='$deleteurl' method='POST' style='display:inline;'>
                        //         <input type='hidden' name='_token' value='$csrf_token'>
                        //         <input type='hidden' name='_method' value='DELETE' />
                        //            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                        //        </form>
                        //        ";

                                return $btn;
                    })
                    ->rawColumns(['image', 'action'])
                    ->make(true);
            }
            return view('backend.staffs.index');
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
        if(checkpermission(Auth::user()->role_id, 4)){
            $position = Position::where('status', 1)->get();
            $roles = Role::get();
            return view('backend.staffs.create', compact('position', 'roles'));
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
            'position' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'national_id' => 'required|mimes:pdf',
            'documents' => 'required|mimes:pdf',
            'contract' => 'required|mimes:pdf',
            'allocated_salary' => '',
            'role' => ''
        ]);

        if($request['role'] == 1)
            {
                $position = Position::where('id', $request['position'])->first();
                $role = Role::where('slug', $position->slug)->first();
                if($role)
                {
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'role_id' => $role->id,
                        'password' => Hash::make('password'),
                    ]);
                    $user->save();
                }
                else
                {
                    return redirect()->back()->with('failure', 'Your position doesnot have role.');
                }
            }
            $salary = 0;
            if($request['allocated_salary'] == null){
                $salary = 0;
            }else{
                $salary = $request['allocated_salary'];
            }

        $imagename = '';
        $national_id_name = '';
        $documents_name = '';
        $contract_name = '';
        if($request->hasfile('image') && $request->hasfile('national_id') && $request->hasfile('documents') && $request->hasfile('contract')){
            $image = $request->file('image');
            $national_id = $request->file('national_id');
            $documents = $request->file('documents');
            $contract = $request->file('contract');
            $imagename = $image->store('staff_docs', 'uploads');
            $national_id_name = $national_id->store('staff_docs', 'uploads');
            $documents_name = $documents->store('staff_docs', 'uploads');
            $contract_name = $contract->store('staff_docs', 'uploads');

            $staff = Staff::create([
                'position_id' => $data['position'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'image' => $imagename,
                'national_id' => $national_id_name,
                'documents' => $documents_name,
                'contract' => $contract_name,
                'allocated_salary' => $salary,
                'has_role' => $data['role'],
                'status' => 1,
            ]);

            $staff->save();
            return redirect()->route('admin.staff.index')->with('success', 'New Staff added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Staff::where('id', $id)->with('position')->first();
        $user = User::where('name', $staff->name)->first();
        return view('backend.staffs.show', compact('staff', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::findorFail($id);
        $position = Position::where('status',1)->get();
        $user = User::where('name', $staff->name)->first();
        $roles = Role::get();
        return view('backend.staffs.edit', compact('staff', 'position', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findorFail($id);

        $data = $this->validate($request, [
            'position' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg',
            'national_id' => 'mimes:pdf',
            'documents' => 'mimes:pdf',
            'contract' => 'mimes:pdf',
            'allocated_salary' => 'required|numeric',
            'role' => ''
        ]);

        $imagename = '';
        $national_id_name = '';
        $documents_name = '';
        $contract_name = '';

        if ($data['role'] == 1) {
            $position = Position::where('id', $request['position'])->first();
            $role = Role::where('slug', $position->slug)->first();
            if($role)
            {
                $user = User::where('name', $staff->name)->first();
                if($user)
                {
                    $user->update([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'role_id' => $role->id,
                    ]);
                }
                else
                {
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'role_id' => $role->id,
                        'password' => Hash::make('password'),
                    ]);
                    $user->save();
                }
            }
            else
            {
                return redirect()->back()->with('failure', 'Your position doesnot have role.');
            }

        }
        elseif($request['role'] == 0)
        {
            $user = User::where('name', $staff->name)->first();
            if($user)
            {
                $user->delete();
            }
        }
        if($request->hasfile('image')){
            $image = $request->file('image');

            Storage::disk('uploads')->delete($staff->image);
            $imagename = $image->store('staff_docs', 'uploads');

            $staff->update([
                'image' => $imagename,
            ]);
        }
        if($request->hasfile('national_id')){
            $national_id = $request->file('national_id');

            Storage::disk('uploads')->delete($staff->national_id);
            $national_id_name = $national_id->store('staff_docs', 'uploads');

            $staff->update([
                'national_id' => $national_id_name,
            ]);
        }
        if($request->hasfile('documents')){
            $documents = $request->file('documents');

            Storage::disk('uploads')->delete($staff->documents);
            $documents_name = $documents->store('staff_docs', 'uploads');

            $staff->update([
                'documents' => $documents_name,
            ]);
        }
        if($request->hasfile('contract')){
            $contract = $request->file('contract');

            Storage::disk('uploads')->delete($staff->contract);
            $contract_name = $contract->store('staff_docs', 'uploads');

            $staff->update([
                'contract' => $contract_name,
            ]);
        }
        $staff->update([
            'position_id' => $data['position'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'allocated_salary' => $data['allocated_salary'],
            'has_role' => $data['role'],
        ]);
        return redirect()->route('admin.staff.index')->with('success', 'Staff information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::findorFail($id);
        $projects = Project::get();
        $attendance = Attendance::where('staff_id', $staff->id)->get();
        $visitorconcerned = Visitor::where('concerned_with', $staff->id)->get();
        $visitorassigned = Visitor::where('assigned_to', $staff->id)->get();
        // dd(count($visitorconcerned));

        if(count($visitorconcerned) > 0)
        {
            return redirect()->back()->with('failure', 'Staff is involved with visitor. Cannot delete.');
        }
        elseif(count($visitorassigned) > 0)
        {
            return redirect()->back()->with('failure', 'Staff is involved with visitor. Cannot delete.');
        }

        foreach ($projects as $project) {
            if (in_array($staff->id, $project->completed_by)) {
                return redirect()->back()->with('failure', 'Staff is involved in project. Cannot delete.');
            }
        }

        $user = User::where('name', $staff->name)->first();

        Storage::disk('uploads')->delete($staff->image);
        Storage::disk('uploads')->delete($staff->national_id);
        Storage::disk('uploads')->delete($staff->documents);
        Storage::disk('uploads')->delete($staff->contract);

        if($user != null)
        {
            $user->delete();
        }

        foreach ($attendance as $attend) {
            $attend->delete();
        }

        $staff->delete();
        return redirect()->back()->with('success', 'Staff information deleted successfully.');
    }


    public function disablestaff($id)
    {
        $position = Staff::findorfail($id);
        $position->update([
            'status' => '0',
        ]);
        //$staff->save();
        return redirect()->route('admin.staff.index')->with('success', 'Staff Disabled Successfully.');

    }

    public function enablestaff($id)
    {
        $position = Staff::findorfail($id);
        $position->update([
            'status' => '1',
        ]);
        //$staff->save();
        return redirect()->route('admin.staff.index')->with('success', 'Staff Enabled Successfully.');

    }
}
