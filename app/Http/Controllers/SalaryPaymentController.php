<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\SalaryPayment;
use App\Models\Staff;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Facades\Auth;

class SalaryPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $date = date('F, Y');
            $data = SalaryPayment::where('monthyear', $date)->with('staff')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('staffname', function($row){
                        $staffname = $row->staff->name;
                        return $staffname;
                    })
                    ->addColumn('position', function($row){
                        $position = $row->staff->position_id;
                        $positionname = Position::where('id', $position)->first();
                        return $positionname->name;
                    })
                    ->addColumn('allocated_salary', function($row){
                        $allocated_salary = 'Rs. '.$row->staff->allocated_salary;
                        return $allocated_salary;
                    })
                    ->addColumn('amount', function($row){
                        $amount = 'Rs. '.$row->amount;
                        return $amount;
                    })
                    ->addColumn('paid_on', function($row){
                        $paid_on = date('F j, Y', strtotime($row->payment_date));
                        return $paid_on;
                    })
                    ->addColumn('salary_type', function($row){
                        $salary_type = '';
                        if ($row->salary_type == 'advance') {
                            $salary_type = 'Advance';
                        }elseif ($row->salary_type == 'regular') {
                            $salary_type = 'Regular';
                        }
                        return $salary_type;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.salarypayment.edit', $row->id);
                       $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('backend.staffs.payment');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(checkpermission(Auth::user()->role_id, 5)){
            $staffs = Staff::latest()->get();
            return view('backend.staffs.payment', compact('staffs'));
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
            'staff_id' => 'required',
            'payment_date' => 'required',
            'amount' => 'required|numeric',
            'salary_type' => 'required',
        ]);

        $monthyear = date('F, Y', strtotime($request['payment_date']));

        $salaryPayment = SalaryPayment::create([
            'staff_id' => $data['staff_id'],
            'payment_date' => $data['payment_date'],
            'amount' => $data['amount'],
            'salary_type' => $data['salary_type'],
            'monthyear' => $monthyear
        ]);

        $salaryPayment->save();

        return redirect()->route('admin.salarypayment.create')->with('success', 'Salary Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalaryPayment  $salaryPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SalaryPayment $salaryPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalaryPayment  $salaryPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salarypayment = SalaryPayment::findorFail($id);
        $staffs = Staff::get();
        return view('backend.staffs.editpayment', compact('salarypayment', 'staffs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalaryPayment  $salaryPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $salaryPayment = SalaryPayment::findorFail($id);

        $data = $this->validate($request, [
            'staff_id' => 'required',
            'payment_date' => 'required',
            'amount' => 'required|numeric',
            'salary_type' => 'required',
        ]);

        $monthyear = date('F, Y', strtotime($request['payment_date']));

        $salaryPayment->update([
            'staff_id' => $data['staff_id'],
            'payment_date' => $data['payment_date'],
            'amount' => $data['amount'],
            'salary_type' => $data['salary_type'],
            'monthyear' => $monthyear
        ]);
        return redirect()->route('admin.salarypayment.create')->with('success', 'Salary Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalaryPayment  $salaryPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalaryPayment $salaryPayment)
    {
        //
    }

    public function salaryreport()
    {
        // $date = date('F, Y');
        // $staff = Staff::where('position', '!=', 11)->latest()->first();
        // $thismonthattendance = Attendance::where('monthyear', $date)->where('staff_id', $staff->id)->get();
        if(checkpermission(Auth::user()->role_id, 6)){
            return view('backend.staffs.report');
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }

    public function salaryreportgenerate(Request $request)
    {
        $data = $this->validate($request, [
            'monthyear' => 'required'
        ]);

        $datetoselect = date('F, Y', strtotime($data['monthyear']));
        $salaryreport = SalaryPayment::where('monthyear', $datetoselect)->with('staff')->get();

        return view('backend.staffs.result', compact('salaryreport', 'datetoselect'));
    }
}
