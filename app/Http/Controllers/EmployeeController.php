<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderProcess;
use App\Models\Process;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a list of orders assigned to the authenticated employee.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $employeeWorks = OrderProcess::with('employee', 'order')->where('employee_id', Auth::id())->get();
            // dd($employeeWorks);
            return view('employee.work_list', compact('employeeWorks'));
        } catch (\Exception $e) {
            Log::error('Error fetching employee work list: ' . __METHOD__ . ' - ' . $e->getMessage());
            return redirect()->back();
        }
    }
    /**
     * Update the start time of an order process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function startWork(Request $request)
    {
        try {
            $getId = $request->id;
            $getOrderProcess = OrderProcess::find($getId);
            if ($getOrderProcess) {
                $getOrderProcess->update([
                    'start_time' => now()
                ]);
                return response()->json(['message' => 'Work started successfully']);
            } else {
                return response()->json(['message' => 'Order process not found']);
            }
        } catch (\Exception $e) {

            Log::error('Error starting work for OrderProcess: ' . __METHOD__ .  $e->getMessage());

            return response()->json(['error' => 'Failed to start work. Please try again.'], 500);
        }
    }

    /**
     * Mark the end time of an order process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function endWork(Request $request)
    {
        try {
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
        } catch (\Exception $e) {

            Log::error('Error completing work for OrderProcess: '  . __METHOD__ .  $e->getMessage());

            return response()->json(['error' => 'Failed to complete work. Please try again.'], 500);
        }
    }

    /**
     * Display a list of notifications for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function viewNotifications()
    {
        try {
            $getNotifications = auth()->user()->notifications;
            // dd($getNotifications);
            return view('employee.notifications', compact('getNotifications'));
        } catch (\Exception $e) {
            Log::error('Error retrieving notifications: ' . __METHOD__ . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to retrieve notifications. Please try again.');
        }
    }
    /**
     * Display the next available order process for switching and the list of eligible employees.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function switchProcess($id)
    {
        try {


            //get order process for switch step of next process for particular order
            $processes = OrderProcess::with('order', 'process')->where('order_id', $id)->where('employee_id', null)->limit(1)->get();
            $employees = User::where('role', 'employee')->whereNot('id', Auth::id())->get();


            return view('employee.switch_process', compact('processes', 'employees'));
        } catch (\Exception $e) {
            Log::error('Error switching process: ' . __METHOD__ . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to switch process. Please try again.');
        }
    }

    /**
     * Store the switched process assignment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSwitchProcess(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required',
                'process_id' => 'required',
                'employee_id' => 'required',
            ]);

            $orderId = $validatedData['order_id'];
            $processId = $validatedData['process_id'];
            $employeeId = $validatedData['employee_id'];

            $getOrderProcess = OrderProcess::where('order_id', $orderId)->where('process_id', $processId)->first();

            if ($getOrderProcess) {
                //switch process assign for employee
                $getOrderProcess->update(['employee_id' => $employeeId]);
                return redirect()->route('employees.index')->with('success', 'Switch the process was assign successfully');
            } else {
                return redirect()->route('employees.index')->with('error', 'Something worng process did not assigned');
            }
        } catch (\Exception $e) {
            Log::error('Error storing switch process: ' . __METHOD__ . $e->getMessage());

            return redirect()->route('employees.index')->with('error', 'Failed to switch process. Please try again.');
        }
    }
}
