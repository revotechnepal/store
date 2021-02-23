<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\PurchaseRecord;
use App\Models\RolePermission;
use App\Models\Staff;
use App\Models\ThirdParty;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role_id = Auth::user()->role_id;
        $permissions = RolePermission::where('role_id', $role_id)->first();
        if($permissions){

            $staffs = Staff::get();
            $completed_projects = Project::where('state', 'Completed')->get();
            $clients = Client::get();
            $visitors = Visitor::get();
            $currentmonth = date('F, Y');
            $thirdparty = PurchaseRecord::where('monthyear', $currentmonth)->get();
            $staffcount = $staffs->count();
            $projects = $completed_projects->count();
            $clientcount = $clients->count();
            $visitorscount = $visitors->count();
            $expense = 0;
            foreach ($thirdparty as $party) {
                $expense = $expense + $party->paid_amount;
            }
            // dd($expense);
            return view('backend.index', compact('staffcount', 'projects', 'clientcount', 'visitorscount', 'expense'));
        }else
        {
            Auth::logout();
            return redirect()->route('login')->with('failure', 'Please request admin to assign you permissions first.');
        }
    }
}
