<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
                return view('employee.home');
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
