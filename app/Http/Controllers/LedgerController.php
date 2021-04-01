<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ledgeritem = Ledger::where('monthyear', date('F, Y', strtotime("last month")))->latest()->first();
        if($ledgeritem) {
            $opening_balance = $ledgeritem->balance;
        }else{
            $opening_balance = 0;
        }
        $ledger = Ledger::where('monthyear', date('F, Y'))->get();
        return view('backend.ledger.index', compact('opening_balance', 'ledger'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'date' => 'required',
            'particulars' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required',
        ]);
        $last_balance = Ledger::latest()->first();

        if ($data['type'] == 'debit') {
            $debit_amount = $data['amount'];
            $credit_amount = 0;
            if ($last_balance) {
                $balance = $last_balance->balance + $data['amount'];
            }else {
                $balance = $data['amount'];
            }
        }elseif($data['type'] == 'credit') {
            $credit_amount = $data['amount'];
            $debit_amount = 0;
            if ($last_balance) {
                $balance = $last_balance->balance - $data['amount'];
            }else {
                $balance = -$data['amount'];
            }
        }

        $ledgeritem = Ledger::create([
            'date' => date('F j, Y', strtotime($data['date'])),
            'particulars' => $data['particulars'],
            'debit_amount' => $debit_amount,
            'credit_amount' => $credit_amount,
            'balance' => $balance,
            'monthyear' => date('F, Y', strtotime($data['date']))
        ]);

        $ledgeritem->save();
        return redirect()->route('admin.ledger.index')->with('success', 'Record is entried successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ledger $ledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger $ledger)
    {
        //
    }
    public function ledgergenerator()
    {
        return view('backend.ledger.show');
    }
    public function ledgerreport(Request $request)
    {
        $givendate = $request['monthyear'];
        $ledgeritem = Ledger::where('monthyear', date('F, Y', strtotime("$givendate -1 month")))->latest()->first();
        if($ledgeritem) {
            $opening_balance = $ledgeritem->balance;
        }else{
            $opening_balance = 0;
        }
        $ledger = Ledger::where('monthyear', date('F, Y', strtotime($givendate)))->get();
        $closedledger = Ledger::where('monthyear', date('F, Y', strtotime($givendate)))->latest()->first();
        if($closedledger) {
            $closing_balance = $closedledger->balance;
        }else{
            $closing_balance = 0;
        }
        return view('backend.ledger.report', compact('opening_balance', 'ledger', 'givendate', 'closing_balance'));
    }
}
