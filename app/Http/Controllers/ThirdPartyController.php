<?php

namespace App\Http\Controllers;

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
                    $deleteurl = route('admin.thirdparty.destroy', $row->id);
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
    public function show(ThirdParty $thirdParty)
    {
        //
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
}
