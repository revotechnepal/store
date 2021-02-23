<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Staff;
use Illuminate\Http\Request;
use DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function($row){
                    $type = '';
                    if ($row->type == 'advance') {
                        $type = 'Advance';
                    }elseif ($row->type == 'regular') {
                        $type = 'Regular';
                    }elseif ($row->type == 'overdue') {
                        $type = 'Overdue';
                    }
                    return $type;
                })
                ->addColumn('date', function($row){
                    $paiddate = date('F j, Y ', strtotime($row->date));
                    return $paiddate;
                })
                ->addColumn('staff', function($row){
                    $staff = $row->staff->name;
                    return $staff;
                })
                ->addColumn('amount', function($row){
                    $amount = 'Rs. '.$row->amount;
                    return $amount;
                })
                ->addColumn('action', function($row){
                    $previewurl = route('pdf.generate', $row->id);
                    $editurl = route('admin.payment.edit', $row->id);
                    $deleteurl = route('admin.payment.destroy', $row->id);
                    $csrf_token = csrf_token();
                    $btn = "<a href='$previewurl' class='edit btn btn-info btn-sm' target='_blank'>Download (in PDF)</a>
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                           <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                               <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                           </form>
                           ";

                            return $btn;
                })
                ->rawColumns(['type', 'date', 'staff', 'amount', 'action'])
                ->make(true);
        }
        return view('backend.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Staff::latest()->where('position_id', '!=', 11)->get();
        return view('backend.payment.create', compact('staff'));
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
            'date' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required',
        ]);

        $payment = Payment::create([
            'staff_id' => $data['staff_id'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'type' => $data['type'],
        ]);

        $payment->save();

        return redirect()->route('admin.payment.index')->with('success', 'Payment Information saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::findorFail($id);
        $staff = Staff::latest()->where('position_id', '!=', 11)->get();

        return view('backend.payment.edit', compact('payment', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findorFail($id);

        $data = $this->validate($request, [
            'staff_id' => 'required',
            'date' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required',
        ]);

        $payment->update([
            'staff_id' => $data['staff_id'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'type' => $data['type'],
        ]);

        return redirect()->route('admin.payment.index')->with('success', 'Invoice information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::findorFail($id);
        $payment->delete();

        return redirect()->route('admin.payment.index')->with('success', 'Invoice information deleted successfully.');

    }
}
