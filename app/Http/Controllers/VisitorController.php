<?php

namespace App\Http\Controllers;

use App\Mail\VisitorMail;
use App\Models\Staff;
use App\Models\Visitor;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(checkpermission(Auth::user()->role_id, 15)){
            if ($request->ajax()) {
            $data = Visitor::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('dateofvisit', function($row){
                    $dateofvisit = date('F j, Y  h:i a', strtotime($row->dateofvisit));
                    return $dateofvisit;
                })
                ->addColumn('concerned_with', function($row){
                    $concerned_with = Staff::where('id', $row->concerned_with)->first();
                    $name = $concerned_with->name;
                    return $name;
                })
                ->addColumn('assigned_to', function($row){
                    $assigned_to = Staff::where('id', $row->assigned_to)->first();
                    $name = $assigned_to->name;
                    return $name;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.visitor.edit', $row->id);
                    $deleteurl = route('admin.visitor.destroy', $row->id);
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
                ->rawColumns(['dateofvisit', 'concerned_with', 'assigned_to', 'action'])
                ->make(true);
        }
        return view('backend.visitors.index');
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
        if(checkpermission(Auth::user()->role_id, 15)){
            $staff = Staff::latest()->get();
            return view('backend.visitors.create', compact('staff'));
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
        // dd(date('Y-m-d h:i a', strtotime($request['dateofvisit'])));
        $data = $this->validate($request, [
            'name' => 'required',
            'dateofvisit' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'reason' => '',
            'concerned_with' => '',
            'assigned_to' => ''
        ]);

        $visitor = Visitor::create([
            'name' => $data['name'],
            'dateofvisit' => $data['dateofvisit'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'reason' => $data['reason'],
            'concerned_with' => $request['concerned_with'],
            'assigned_to' => $request['assigned_to'],
        ]);

        $visitor->save();

        $mailData = [
            'name' => $data['name'],
        ];
        Mail::to($data['email'])->send(new VisitorMail($mailData));
        return redirect()->route('admin.visitor.index')->with('success', 'Visitor information added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = Visitor::findorFail($id);
        $staff = Staff::latest()->get();
        return view('backend.visitors.edit', compact('visitor', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'dateofvisit' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'reason' => '',
            'concerned_with' => '',
            'assigned_to' => ''
        ]);

        $visitor = Visitor::findorFail($id);

        $visitor->update([
            'name' => $data['name'],
            'dateofvisit' => $data['dateofvisit'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'reason' => $data['reason'],
            'concerned_with' => $request['concerned_with'],
            'assigned_to' => $request['assigned_to'],
        ]);

        return redirect()->route('admin.visitor.index')->with('success', 'Visitor information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitor = Visitor::findorFail($id);
        $visitor->delete();

        return redirect()->back()->with('success', 'Visitor information deleted successfully.');
    }
}
