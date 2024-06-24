<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEmployeeRequest;
use App\Http\Requests\StoreProcessRequest;
use App\Models\Order;
use App\Models\OrderProcess;
use App\Models\Process;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of all processes.
     *
     * This method retrieves all processes from the database
     * to the view, allowing it to be accessed within the view file.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $processes = Process::all();

        return view('admin.home')->with('processes', $processes);
    }

    /**
     * Display the form to add a new process.
     *
     * @return \Illuminate\View\View
     */
    public function addProcess()
    {
        return view('admin.process.add_process');
    }

    /**
     * Store a newly created process in the database.
     *
     * @param  \Illuminate\Http\Request  $request get user input datas
     * @return \Illuminate\Http\Response
     */

    public function storeProcess(StoreProcessRequest $request)
    {
        try {
            $processName = $request->validated();
            Process::create($processName);
            return redirect()->route('admin.body')->with('success', 'Process created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in ' . __METHOD__ . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to store process. Please try again.');
        }
    }
    /**
     * Display the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response-- return admin.process.edit_process view page
     */
    public function editProcess($id)
    {

        $process = Process::find($id);
        return view('admin.process.edit_process', compact('process'));
    }
    /**
     * Updates an existing process with the provided data.
     *
     * @param StoreProcessRequest $request The request object containing validated data.
     * @param int $id The ID of the process to update.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the body index with a success or error message.
     */
    public function updateProcess(StoreProcessRequest $request, $id)
    {
        try {
            $getProcess = Process::findorFail($id);
            $validateData = $request->validated();
            $getProcess->update($validateData);
            return redirect()->route('admin.body')->with('success', 'Process was updated successfully');
        } catch (\Exception $e) {
            Log::info('Error in ' . __METHOD__ . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update process. Please try again.');
        }
    }

    /**
     * Deletes an existing process by its ID.
     *
     * @param int $id The ID of the process to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects to the body index with a success or error message.
     */

    public function deleteProcess($id)
    {
        $getProcess = Process::find($id);
        if ($getProcess) {
            $getProcess->delete();
            return redirect()->route('admin.body')->with('success', 'Process was deleted successfully');
        } else {
            return redirect()->route('admin.body')->with('error', 'Process not found');
        }
    }


    /**
     * Display a list of employees.
     *
     * Retrieves users with the role 'employee' from the database
     * and renders a view to display them.
     *
     * @return \Illuminate\View\View
     */
    public function showEmployees()
    {
        $employees = User::where('role', 'employee')->get();
        // dd($employees);
        return view('admin.employees.employee_list', compact('employees'));
    }
    /**
     * Display the form to edit an employee.
     *
     * Retrieves the employee details from the database based on the given ID,
     * and renders a view to edit those details.
     *
     * @param  int  $id The ID of the employee to edit
     * @return \Illuminate\View\View
     */
    public function editEmployee($id)
    {

        $getEmployee = User::find($id);
        // dd($getEmployee);
        return view('admin.employees.edit_employee', compact('getEmployee'));
    }


    public function updateEmployee(Request $request, $id)
    {
        try {
            $employee = User::find($id);
            $validateData = $request->validate([
                'emp_name' => 'required|string|max:50',
                'phone' => 'required|numeric|digits:10',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($employee->id),
                ],
                'password' => 'nullable|string|min:8', // Password is optional because admin cannot see user password.but allows to change password or existing password store default
            ], [
                'emp_name.required' => 'The employee name is required.',
                'emp_name.string' => 'The employee name must be a string.',
                'emp_name.max' => 'The employee name may not be greater than 50 characters.',

                'phone.required' => 'The phone number is required.',
                'phone.string' => 'The phone number must be a string.',
                'phone.max' => 'The phone number may not be greater than 10 digits.',

                'email.required' => 'The email address is required.',
                'email.email' => 'The email address must be a valid email format.',
                'email.unique' => 'The email address has already been taken.',

                'password.string' => 'The password must be a string.',
                'password.min' => 'The password must be at least 8 characters.',
            ]);



            // Always include password field in validated data, even if it's null
            if (!empty($validateData['password'])) {
                $validateData['password'] = Hash::make($validateData['password']);
            } else {
                unset($validateData['password']); //  we remove it from the update data when not provided.
            }

            $res = $employee->update($validateData);
            return redirect()->route('admin.show_employees')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . __METHOD__ . $e->getMessage());
            return redirect()->route('admin.show_employees')->with('error', 'An error occurred while updating the employee. Please try again.');
        }
    }

    public function deleteEmployee($id)
    {
        $getEmployee = User::find($id);

        if ($getEmployee) {
            $getEmployee->delete();
            return redirect()->route('admin.show_employees')->with('success', 'Employee was deleted successfully');
        } else {
            return redirect()->route('admin.show_employees')->with('error', 'Employee not found');
        }
    }

    public function addEmployee()
    {
        return view('admin.employees.add_employee');
    }

    public function storeEmployee(AddEmployeeRequest $request)
    {
        try {
            $Employee = $request->validated();
            $Employee['password'] = Hash::make($Employee['password']);

            User::create($Employee);
            return redirect()->route('admin.show_employees')->with('success', 'New employee added successfully');
        } catch (\Exception $e) {
            Log::error('Error Add Employee: ' . __METHOD__ . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to store process. Please try again.');
        }
    }

    //list of assign order
    public function assignList()
    {
        $getAssignOrders = OrderProcess::whereNotNull('employee_id')->get();
        return view('admin.order.assign_order_list', compact('getAssignOrders'));
    }
    //form for assign order
    public function assignOrder()
    {

        $getOrderProcesses = Order::with('processes')->get();

        // dd( $getOrderProcesses);
        $employees = User::where('role', 'employee')->get();
        return view('admin.order.assign', compact('getOrderProcesses', 'employees'));
    }
    //ajax request function
    public function getProcessesByOrderId($id)
    {
        $processes = OrderProcess::with('process')->where('order_id', $id)->where('start_time', null)->limit(1)->get();

        // Check if processes are found
        // if ($processes->isEmpty()) {
        //     return response()->json(['success' => 'false','message' => 'No processes found for the selected order.'], 404);
        // }

        return response()->json(['success' => true, 'data' => ['processes' => $processes]], 200);
    }


    public function storeAssign(Request $request)
    {

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
            //assign to work for employee
            $getOrderProcess->update(['employee_id' => $employeeId]);
            return redirect()->route('admin.assign_list')->with('success', 'Order was assign successfully');
        } else {
            return redirect()->route('admin.assign_list')->with('error', 'Something worng order did not assigned');
        }
    }


    public function editAssign($id)
    {
        $getAssign = OrderProcess::find($id);
        return view('order.edit_assign');
    }
}
