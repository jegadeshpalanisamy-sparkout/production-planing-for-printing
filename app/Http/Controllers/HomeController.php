<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderProcess;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        
        if(Auth::id())
        {
            $role=auth()->user()->role;
            if($role=='employee')
            {
                $employeeWorks = OrderProcess::with('employee', 'order')->where('employee_id', Auth::id())->get();
                return view('employee.work_list', compact('employeeWorks'));
            }
            else
            {
                $processes =Process::all();
                return view('admin.home')->with('processes',$processes);
            }
        }
        else
        {
            return redirect()->back();
        }
    }
}
