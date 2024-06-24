<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Order;
use App\Models\OrderProcess;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderReportsController extends Controller
{
    //
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        switch ($filter) {
            case 'on_time':
                $orders = Order::OnTime();
                break;
            case 'late':
                $orders = Order::Late();
                break;
            default:
                $orders = Order::with('processes')->get();
                break;
        }

        return view('admin.reports.order_reports', compact('orders'));
        // $orders = Order::with('processes')
        // ->whereHas('processes', function ($query) {
        //     $query->whereNotNull('end_time');
        // })
        // ->get()
        // ->filter(function ($order) {
        //     // Check if all processes have end_time
        //     $allProcessesEnded = $order->processes->every(function ($process) {
        //         return $process->end_time !== null;
        //     });

        //     if (!$allProcessesEnded) {
        //         return false; // Skip orders where not all processes have end_time
        //     }

        //     // Check if the last process end_time is less than estimate_delivery_date
        //     $lastProcess = $order->processes->last();
        //     return $lastProcess->end_time < new Carbon($order->estimate_delivery_date);
        // });


        //  dd($orders);
        return view('admin.reports.order_reports', compact('orders'));
    }

    public function billings()
    {
        $getOrders = Order::whereDoesntHave('billing')
            ->get();


        return view('admin.billings.bill', compact('getOrders'));
    }

    public function storeBill(Request $request)
    {
        // dd($request->all()); // Debugging statement to check request data

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
        ]);

        try {
            // Create a new Billing instance
            $billingData = Billing::create([
                'order_id' => $request->input('order_id'),
                'amount' => $request->input('amount'),
            ]);

            return redirect()->route('admin.bill_index')->with('success', 'Billing information stored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to store billing information. ' . $e->getMessage())->withInput();
        }
    }

    public function listBill()
    {
        $getAllBills = Billing::with('order')->paginate(5);
        // dd($getAllBills);
        return view('admin.billings.index', compact('getAllBills'));
    }

    public function editBill($id)
    {
        try {
            $getBill = Billing::findOrFail($id);
            $getOrders = Order::all();
            return view('admin.billings.edit', compact('getBill', 'getOrders'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bill_index')->with('error', 'Billing record not found.');
        }
    }

    public function updateBill(Request $request, $id)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $billing = Billing::findOrFail($id);
            $billing->order_id = $request->order_id;
            $billing->amount = $request->amount;
            $billing->save();

            return redirect()->route('admin.bill_index')->with('success', 'Billing record updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bill_index')->with('error', 'Failed to update billing record.');
        }
    }
    public function deleteBill($id)
    {
        try{
            $getBill=Billing::find($id);
            $getBill->delete();
            return redirect()->route('admin.bill_index')->with('success','Billing record was deleted successfully.');
        }
        catch(\Exception $e)
        {
            return redirect()->route('admin.bill_index')->with('error','Billing record was deleted successfully.');

        }

    }
}
