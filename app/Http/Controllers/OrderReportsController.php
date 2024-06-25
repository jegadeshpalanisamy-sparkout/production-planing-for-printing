<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Order;
use App\Models\OrderProcess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderReportsController extends Controller
{
    /**
     * Display a filtered list of orders based on their status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
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


        //  dd($orders);
        return view('admin.reports.order_reports', compact('orders'));
    }

    /**
     * Display a list of orders that do not have associated billing records.billing form
     *
     * @return \Illuminate\View\View
     */
    public function billings()
    {
        try {
            $getOrders = Order::whereDoesntHave('billing')
                ->get();


            return view('admin.billings.bill', compact('getOrders'));
        } catch (\Exception $e) {

            Log::error('Error fetching orders without billing records: ' . __METHOD__ . ' - ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to fetch orders without billing records. Please try again.');
        }
    }
    /**
     * Store the billing information for an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
    /**
     * Display a list of all billing records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function listBill()
    {
        $getAllBills = Billing::with('order')->paginate(5);
        // dd($getAllBills);
        return view('admin.billings.index', compact('getAllBills'));
    }

    /**
     * Display the form for editing a billing record.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
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
    /**
     * Update the billing record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Delete the billing record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBill($id)
    {
        try {
            $getBill = Billing::find($id);
            $getBill->delete();
            return redirect()->route('admin.bill_index')->with('success', 'Billing record was deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bill_index')->with('error', 'Billing record was deleted successfully.');
        }
    }
}
