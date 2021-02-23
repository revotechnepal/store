<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRecord;
use App\Models\ThirdParty;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class PurchaseRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 14)){
            if ($request->ajax()) {
                $data = PurchaseRecord::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('date', function($row){
                        $date = date('F j, Y', strtotime($row->purchase_date));
                        return $date;
                    })
                    ->addColumn('bill_amount', function($row){
                        $bill_amount = 'Rs. '. $row->bill_amount;
                        return $bill_amount;
                    })
                    ->addColumn('paid_amount', function($row){
                        $paid_amount = 'Rs. '. $row->paid_amount;
                        return $paid_amount;
                    })
                    ->addColumn('action', function($row){
                        $editurl = route('admin.purchaserecord.edit', $row->id);
                        $deleteurl = route('admin.purchaserecord.destroy', $row->id);
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
                    ->rawColumns(['date', 'bill_amount', 'paid_amount', 'action'])
                    ->make(true);
            }
            return view('backend.purchaseRecord.index');
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
        if(checkpermission(Auth::user()->role_id, 14)){
            $thirdParty = ThirdParty::get();
            return view('backend.purchaseRecord.create', compact('thirdParty'));
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
        // dd($request['purchase_date']);
        $data = $this->validate($request, [
            'thirdparty_name' => 'required',
            'purchase_date' => 'required',
            'bill_number' => 'required|numeric',
            'bill_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'purpose' => 'required',
        ]);

        $currentyear = date('F, Y');

        $purchaseRecord = PurchaseRecord::create([
            'thirdparty_name' => $data['thirdparty_name'],
            'purchase_date' => $data['purchase_date'],
            'bill_number' => $data['bill_number'],
            'bill_amount' => $data['bill_amount'],
            'paid_amount' => $data['paid_amount'],
            'purpose' => $data['purpose'],
            'monthyear' => $currentyear,
        ]);

        $purchaseRecord->save();
        return redirect()->route('admin.purchaserecord.index')->with('success', 'Purchase Record Information saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseRecord  $purchaseRecord
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseRecord $purchaseRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseRecord  $purchaseRecord
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thirdParty = ThirdParty::get();
        $purchaseRecord = PurchaseRecord::findorFail($id);

        return view('backend.purchaseRecord.edit', compact('thirdParty', 'purchaseRecord'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseRecord  $purchaseRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchaseRecord = PurchaseRecord::findorFail($id);
        $data = $this->validate($request, [
            'thirdparty_name' => 'required',
            'purchase_date' => 'required',
            'bill_number' => 'required|numeric',
            'bill_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'purpose' => 'required',
        ]);

        $currentyear = date('F, Y');

        $purchaseRecord->update([
            'thirdparty_name' => $data['thirdparty_name'],
            'purchase_date' => $data['purchase_date'],
            'bill_number' => $data['bill_number'],
            'bill_amount' => $data['bill_amount'],
            'paid_amount' => $data['paid_amount'],
            'purpose' => $data['purpose'],
            'monthyear' => $currentyear,
        ]);

        return redirect()->route('admin.purchaserecord.index')->with('success', 'Purchase Record Information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseRecord  $purchaseRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchaseRecord = PurchaseRecord::findorFail($id);
        $purchaseRecord->delete();
        return redirect()->route('admin.purchaserecord.index')->with('success', 'Purchase Record Information deleted successfully.');
    }
}
