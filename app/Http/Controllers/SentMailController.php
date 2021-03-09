<?php

namespace App\Http\Controllers;

use App\Models\SentMail;
use Illuminate\Http\Request;
use DataTables;

class SentMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SentMail::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('sent_on', function($row){
                        $sent_on = date('F j, Y', strtotime($row->created_at));
                        return $sent_on;
                    })
                    ->addColumn('action', function($row){
                        $showurl = route('admin.sentmails.show', $row->id);
                        $btn = "<a href='$showurl' class='edit btn btn-info btn-sm'>Show</a>";
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('backend.sentmail.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SentMail  $sentMail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sentmail = SentMail::findorFail($id);
        return view('backend.sentmail.show', compact('sentmail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SentMail  $sentMail
     * @return \Illuminate\Http\Response
     */
    public function edit(SentMail $sentMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SentMail  $sentMail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SentMail $sentMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SentMail  $sentMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SentMail $sentMail)
    {
        //
    }
}
