<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProcess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeReportsController extends Controller
{
    //

    public function index()
    {
        try{
            $getEmployees=User::where('role','employee')->get();
            $getOrders=Order::all();
            // dd($getOrderProcess);
            return view('admin.reports.employee_reports',compact('getEmployees','getOrders'));
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', 'not found.');
        }

       
       
    }

    public function getOrderProcessByEmpId(Request $request)
    {
            
            $getOrderProcess=OrderProcess::with('order','process')->where('employee_id',$request->id)->get();
            return response()->json(['success' => true, 'data' => $getOrderProcess, 200]);
        
       

    }

    public function getEmpOrder(Request $request)
    {
        $employeeId=$request->employeeId;
        $orderId=$request->orderId;

        $filterData=OrderProcess::with('order','process','employee')
                    ->where('employee_id',$employeeId)
                    ->where('order_id',$orderId)
                    ->get();
        return response()->json(['success' => true, 'data' => $filterData, 200]);

    }   
}
