<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRecord;
use App\Models\ThirdParty;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ThirdPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 13)){
            if ($request->ajax()) {
            $data = ThirdParty::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('pan', function($row){
                    $pan = '';
                    if ($row->pan == null) {
                        $pan = 'Not Provided';
                    }
                    else{
                        $pan = $row->pan;
                    }
                    return $pan;
                })
                ->addColumn('email', function($row){
                    $email = '';
                    if ($row->email == null) {
                        $email = 'Not Provided';
                    }
                    else{
                        $email = $row->email;
                    }
                    return $email;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.thirdparty.edit', $row->id);
                    $showurl = route('admin.thirdparty.show', $row->id);
                    $deleteurl = route('admin.thirdparty.destroy', $row->id);
                    $csrf_token = csrf_token();
                    $btn = "<a href='$showurl' class='edit btn btn-info btn-sm'>Expenses and Dues</a>
                            <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                           <form action='$deleteurl' method='POST' style='display:inline;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                               <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                           </form>
                           ";

                            return $btn;
                })
                ->rawColumns(['pan', 'email', 'action'])
                ->make(true);
        }
        return view('backend.thirdparty.index');
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
        if(checkpermission(Auth::user()->role_id, 13)){
            return view('backend.thirdparty.create');
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
            'contact_name' => 'required',
            'email' => '',
            'phone' => 'required|numeric',
            'pan' => '',
            'address' => 'required',
        ]);

        $thirdParty = ThirdParty::create([
            'name' => $data['name'],
            'contact_name' => $data['contact_name'],
            'email' => $request['email'],
            'phone' => $data['phone'],
            'pan' => $request['pan'],
            'address' => $data['address'],
        ]);

        $thirdParty->save();

        return redirect()->route('admin.thirdparty.index')->with('success', 'Third Party information saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThirdParty  $thirdParty
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thirdParty = ThirdParty::findorFail($id);
        $monthexpense = PurchaseRecord::where('thirdparty_name', $thirdParty->name)->where('monthyear', date('F, Y'))->get();
        return view('backend.thirdparty.show', compact('thirdParty', 'monthexpense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThirdParty  $thirdParty
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thirdParty = ThirdParty::findorFail($id);
        return view('backend.thirdparty.edit', compact('thirdParty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThirdParty  $thirdParty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $thirdParty = ThirdParty::findorFail($id);

        $data = $this->validate($request, [
            'name' => 'required',
            'contact_name' => 'required',
            'email' => '',
            'phone' => 'required|numeric',
            'pan' => '',
            'address' => 'required',
        ]);

        $thirdParty->update([
            'name' => $data['name'],
            'contact_name' => $data['contact_name'],
            'email' => $request['email'],
            'phone' => $data['phone'],
            'pan' => $request['pan'],
            'address' => $data['address'],
        ]);

        return redirect()->route('admin.thirdparty.index')->with('success', 'Third Party information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThirdParty  $thirdParty
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thirdParty = ThirdParty::findorFail($id);
        $thirdParty->delete();

        return redirect()->route('admin.thirdparty.index')->with('success', 'Third Party information deleted successfully.');
    }

    public function generatereport(Request $request)
    {
        $data = $this->validate($request, [
            'monthyear' => 'required',
            'thirdparty' => 'required'
        ]);

        $thirdParty = ThirdParty::findorFail($request['thirdparty']);
        $datetoselect = date('F, Y', strtotime($data['monthyear']));
        $expenses = PurchaseRecord::where('monthyear', $datetoselect)->where('thirdparty_name', $thirdParty->name)->get();

        return view('backend.thirdparty.result', compact('expenses', 'datetoselect', 'thirdParty'));
    }

    public function paydues($id, $date)
    {
        $thirdParty = ThirdParty::findorFail($id);
        $expenserecord = PurchaseRecord::where('thirdparty_name', $thirdParty->name)->where('monthyear', $date)->get();
        return view('backend.thirdparty.paydue', compact('thirdParty', 'expenserecord', 'date'));
    }

    public function cleardues(Request $request, $id)
    {
        $thirdParty = ThirdParty::findorFail($id);
        $data = $this->validate($request, [
            'amount' => 'required',
            'payment_date' => 'required',
            'bill_number' => 'required'
        ]);
        $reason = "Dues Payment";
        $dueamount = -$data['amount'];

        $olddues = PurchaseRecord::where('thirdparty_name', $thirdParty->name)->where('monthyear', '!=', date('F, Y'))->get();
        $olddueamount = 0;
        foreach ($olddues as $dues) {
            $olddueamount = $olddueamount + $dues->due_amount;
        }

        $leftover = $data['amount'] - $olddueamount;

        if ($leftover == 0) {
            $purchaseRecord = PurchaseRecord::create([
                'thirdparty_name' => $thirdParty->name,
                'purchase_date' => $data['payment_date'],
                'bill_number' => $data['bill_number'],
                'bill_amount' => 0,
                'paid_amount' => $data['amount'],
                'due_amount' => $dueamount,
                'purpose' => $reason,
                'monthyear' => "-",
            ]);
            $purchaseRecord->save();
        }
        elseif ($leftover < 0){
            $purchaseRecord = PurchaseRecord::create([
                'thirdparty_name' => $thirdParty->name,
                'purchase_date' => $data['payment_date'],
                'bill_number' => $data['bill_number'],
                'bill_amount' => 0,
                'paid_amount' => $data['amount'],
                'due_amount' => $dueamount,
                'purpose' => $reason,
                'monthyear' => "-",
            ]);
            $purchaseRecord->save();

        }
        elseif($leftover > 0)
        {
            if ($olddueamount != 0) {
                $purchaseRecord = PurchaseRecord::create([
                    'thirdparty_name' => $thirdParty->name,
                    'purchase_date' => $data['payment_date'],
                    'bill_number' => $data['bill_number'],
                    'bill_amount' => 0,
                    'paid_amount' => $olddueamount,
                    'due_amount' => "-".$olddueamount,
                    'purpose' => "Cleared previous dues",
                    'monthyear' => "-",
                ]);
                $purchaseRecord->save();
            }

            $purchaseRecord2 = PurchaseRecord::create([
                'thirdparty_name' => $thirdParty->name,
                'purchase_date' => $data['payment_date'],
                'bill_number' => $data['bill_number'],
                'bill_amount' => 0,
                'paid_amount' => $data['amount']-$olddueamount,
                'due_amount' => "-".$leftover,
                'purpose' => $reason,
                'monthyear' => date('F, Y'),
            ]);
            $purchaseRecord2->save();
        }
        return redirect()->route('admin.thirdparty.show', $thirdParty->id)->with('success', 'Dues has been paid successfully.');
    }
}
