<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEmployeeRequest;
use App\Http\Requests\StoreProcessRequest;
use App\Http\Requests\UpdateEmployeeRequest;
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
        try {
            $processes = Process::all();

            return view('admin.home')->with('processes', $processes);
        } catch (\Exception $e) {
            Log::error('Error fetching processes: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to fetch processes. Please try again.');
        }
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
        try {
            $process = Process::find($id);
            return view('admin.process.edit_process', compact('process'));
        } catch (\Exception $e) {
            Log::error('Error editing process: ' . __METHOD__ . $e->getMessage());

            return redirect()->back()->with('error', 'Process not found or error occurred.');
        }
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
        try {
            $getProcess = Process::find($id);
            if ($getProcess) {
                $getProcess->delete();
                return redirect()->route('admin.body')->with('success', 'Process was deleted successfully');
            } else {
                return redirect()->route('admin.body')->with('error', 'Process not found');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting process: ' .__METHOD__ .  $e->getMessage());

            return redirect()->back()->with('error', 'Failed to delete process');
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
        $employees = User::where('role', 'employee')->paginate(5);
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
        try {
            $getEmployee = User::find($id);
            // dd($getEmployee);
            return view('admin.employees.edit_employee', compact('getEmployee'));
        } catch (\Exception $e) {
            Log::error('Error editing employee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to edit employee');
        }
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(UpdateEmployeeRequest $request, $id)
    {
        try {
            $employee = User::find($id);
            $validateData = $request->validated();
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
    /**
     * Remove the specified employee from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deleteEmployee($id)
    {
        try {


            $getEmployee = User::find($id);

            if ($getEmployee) {
                $getEmployee->delete();
                return redirect()->route('admin.show_employees')->with('success', 'Employee was deleted successfully');
            } else {
                return redirect()->route('admin.show_employees')->with('error', 'Employee not found');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting employee: ' . __METHOD__ . $e->getMessage());
            return redirect()->route('admin.show_employees')->with('error', 'Failed to delete employee');
        }
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */

    public function addEmployee()
    {
        return view('admin.employees.add_employee');
    }
    /**
     * Store a newly created employee in storage.
     *
     * @param  \App\Http\Requests\AddEmployeeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Display a listing of orders assigned to employees.
     *
     * @return \Illuminate\View\View
     */
    public function assignList()
    {
        try {
            $getAssignOrders = OrderProcess::whereNotNull('employee_id')->paginate(5);
            return view('admin.order.assign_order_list', compact('getAssignOrders'));
        } catch (\Exception $e) {
            Log::error('Error fetching assigned orders: ' . __METHOD__ . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch assigned orders');
        }
    }
    /**
     * Display the form to assign orders to employees.
     *
     * @return \Illuminate\View\View
     */
    public function assignOrder()
    {
        try {
            $getOrderProcesses = Order::with('processes')->get();

            // dd( $getOrderProcesses);
            $employees = User::where('role', 'employee')->get();
            return view('admin.order.assign', compact('getOrderProcesses', 'employees'));
        } catch (\Exception $e) {
            Log::error('Error fetching order processes or employees: ' . __METHOD__ . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch data for assignment');
        }
    }

    //ajax request function
    public function getProcessesByOrderId($id)
    {
        $processes = OrderProcess::with('process')->where('order_id', $id)->where('start_time', null)->limit(1)->get();

        return response()->json(['success' => true, 'data' => ['processes' => $processes]], 200);
    }

    /**
     * Assign an order process to an employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAssign(Request $request)
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
                //assign to work for employee
                $getOrderProcess->update(['employee_id' => $employeeId]);
                return redirect()->route('admin.assign_list')->with('success', 'Order was assign successfully');
            } else {
                return redirect()->route('admin.assign_list')->with('error', 'Something worng order did not assigned');
            }
        } catch (\Exception $e) {
            Log::error('Error assigning order: ' . __METHOD__ . $e->getMessage());

            return redirect()->route('admin.assign_list')->with('error', 'Failed to assign order');
        }
    }
}
