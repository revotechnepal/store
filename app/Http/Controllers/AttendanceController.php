<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (checkpermission(Auth::user()->role_id, 7) == 1) {
            $staffs = Staff::where('status', 1)->get();
            if ($request->ajax()) {
                $date = date('F j, Y');
                $data = Attendance::where('date', $date )->with('staff')->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('staffname', function($row){
                        $staffname = $row->staff->name;
                        return $staffname;
                    })
                    ->addColumn('status', function($row){
                        $status = '';
                        if($row->present == 1){
                            $status = "Present";
                        }elseif($row->paid_leave == 1){
                            $status = "On Paid Leave";
                        }elseif($row->unpaid_leave == 1){
                            $status = "Absent";
                        }
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.attendance.edit', $row->id);
                        $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>";

                        return $btn;
                    })
                    ->rawColumns(['staffname', 'status', 'action'])
                    ->make(true);
            }
            return view('backend.attendance.record', compact('staffs'));
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
        $attendance = Attendance::where('date', date('F j, Y'))->first();
        if ($attendance) {
            return redirect()->back()->with('failure', 'Attendance for today is done.');
        }
        for ( $i=0 ; $i < count($request['staffname']); $i++) {

            $number = $request['staffname'][$i];
            // $this->validate($request,[
            //     '$number' => 'required'
            // ]);

            $present = 0;
            $paid_leave = 0;
            $unpaid_leave = 0;

            if($request[$number] == 1)
            {
                $present = 1;
            }
            elseif($request[$number] == 2)
            {
                $paid_leave = 1;
            }
            elseif($request[$number] == 3)
            {
                $unpaid_leave = 1;
            }

            $attendance = Attendance::create([
                'staff_id' => $number,
                'date' => date('F j, Y'),
                'monthyear' => date('F, Y'),
                'present' => $present,
                'paid_leave' => $paid_leave,
                'unpaid_leave' => $unpaid_leave,
            ]);
            $attendance->save();
        }
        return redirect()->route('admin.attendance.create')->with('success', "Today's attendance record sucessfully recorded.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::findorFail($id);
        return view('backend.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findorFail($id);

        $this->validate($request, [
            'attendance' => 'required'
        ]);

        if($request['attendance'] == 'present')
        {
            $attendance->update([
                'present' => 1,
                'paid_leave' => 0,
                'unpaid_leave' => 0,
            ]);
        }elseif($request['attendance'] == 'paid_leave')
        {
            $attendance->update([
                'present' => 0,
                'paid_leave' => 1,
                'unpaid_leave' => 0,
            ]);
        }elseif($request['attendance'] == 'unpaid_leave')
        {
            $attendance->update([
                'present' => 0,
                'paid_leave' => 0,
                'unpaid_leave' => 1,
            ]);
        }

        return redirect()->route('admin.attendance.create')->with('success', 'Staff Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function report()
    {
        if(checkpermission(Auth::user()->role_id, 7) == 1){
            $date = date('F, Y');
            $staff = Staff::latest()->where('status', 1)->first();
            if($staff)
            {
                $thismonthattendance = Attendance::where('monthyear', $date)->where('staff_id', $staff->id)->get();
                return view('backend.attendance.report', compact('thismonthattendance'));
            }
            else
            {
                return redirect()->route('admin.staff.index')->with('failure', 'Please Create Staff first!');
            }
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }

    }

    public function reportgenerator(Request $request)
    {
        $data = $this->validate($request, [
            'monthyear' => 'required'
        ]);

        $date = date('F, Y');
        $staffs = Staff::latest()->where('status', 1)->get();
        $staff = Staff::latest()->where('status', 1)->first();
        $thismonthattendance = Attendance::where('monthyear', $date)->where('staff_id', $staff->id)->get();

        $datetoselect = date('F, Y', strtotime($data['monthyear']));
        $requireattendance = Attendance::where('monthyear', $datetoselect)->get();
        $requiredmonthattendance = Attendance::where('monthyear', $date)->where('staff_id', $staff->id)->get();

        return view('backend.attendance.result', compact('thismonthattendance', 'requiredmonthattendance', 'requireattendance', 'staffs', 'datetoselect'));
    }
}
