<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    //

    public function index()
    {
        $employeeWorks = OrderProcess::with('employee', 'order')->where('employee_id', Auth::id())->get();
        return view('employee.work_list', compact('employeeWorks'));
    }


    public function startWork(Request $request)
    {
        $getId = $request->id;
        $getOrderProcess = OrderProcess::find($getId);
        if($getOrderProcess){
            $getOrderProcess->update([
                'start_time' => now()
            ]);
            return response()->json(['message' => 'Work started successfully']);
        }
        else{
            return response()->json(['message' => 'Order process not found']);

        }
       
    }

    public function endWork(Request $request)
    {
        $getId = $request->id;
        $getOrderProcess = OrderProcess::find($getId);
        if ($getOrderProcess) {
            $getOrderProcess->update([
                'end_time' => now()
            ]);

            return response()->json(['message' => 'Work completed successfully']);
        } else {
            return response()->json(['message' => 'Order process not found']);
        }
    }


    public function viewNotifications()
    {
        $getNotifications=auth()->user()->notifications;
        // dd($getNotifications);
        return view('employee.notifications',compact('getNotifications'));

    }

    public function switchProcess($id)
    {
        
        //get order process for switch step of next process for particular order
       $processes = OrderProcess::with('order','process')->where('order_id', $id)->where('employee_id',null)->limit(1)->get();
        $employees=User::where('role','employee')->whereNot('id',Auth::id())->get();
       
        
        return view('employee.switch_process',compact('processes','employees'));

    }

//switch process to another employee
    public function storeSwitchProcess(Request $request)
    {
        
        $validatedData = $request->validate([
            'order_id' => 'required',
            'process_id' => 'required',
            'employee_id' => 'required',
        ]);
        
        $orderId=$validatedData['order_id'];
        $processId=$validatedData['process_id'];
        $employeeId=$validatedData['employee_id'];

        $getOrderProcess=OrderProcess::where('order_id',$orderId)->where('process_id',$processId)->first();
        
        if ($getOrderProcess) {
            //switch process assign for employee
            $getOrderProcess->update(['employee_id' => $employeeId]);
            return redirect()->route('employees.index')->with('success','Switch the process was assign successfully');
           
        } else {
            return redirect()->route('employees.index')->with('error','Something worng process did not assigned');
        }
    }
}
