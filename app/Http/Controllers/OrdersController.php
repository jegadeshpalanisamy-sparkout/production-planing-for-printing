<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::with('processes')->get();

        return view('admin.order.order_list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $processes = Process::all();
        return view('admin.order.add_order', compact('processes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $processStepsOrder = json_decode($request->process_steps_order, true);

            $order = Order::create([
                'order_number'=>$request->order_number,
                'customer_name'=>$request->customer_name,
                'customer_phone'=>$request->customer_phone,
                'customer_address'=>$request->customer_address,
                'ordered_date'=>$request->ordered_date,
                'estimate_delivery_date'=>$request->estimate_delivery_date,
                'process_steps'=>$processStepsOrder
            ]);
            
            //    foreach ($request->process_steps_order as $process_id) {
            //     $order->processes()->create(['process_id' => $process_id]);
            // }

            foreach ($processStepsOrder as $process_id) {
                $order->processes()->create(['process_id' => $process_id]);
            }
           

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create order: ' > __METHOD__ . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // $order=Order::with('processes')->where('id',$id)->get();
        $order = Order::with('processes')->findOrFail($id); // Fetch a single order by ID

        // dd($order);
        $processes = Process::all();

        $selectedProcesses = $order->processes()->pluck('process_id')->toArray();

        return view('admin.order.edit_order', compact('order', 'processes', 'selectedProcesses'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrderRequest $request, $id)
    {
        try {
            // Find the existing order by ID
            $order = Order::findOrFail($id);


        // Decode the process steps order
        $processStepsOrder = json_decode($request->process_steps_order, true);

             // Update the order fields
        $order->update([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'ordered_date' => $request->ordered_date,
            'estimate_delivery_date' => $request->estimate_delivery_date,
            'process_steps' => $processStepsOrder
        ]);

            // Detach old processes
            $order->processes()->delete();

            // Attach new processes
            foreach ($processStepsOrder as $process_id) {
                $order->processes()->create(['process_id' => $process_id]);
            }

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update order: ' . __METHOD__ . ' - ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the existing order by ID
            $order = Order::findOrFail($id);

            // Delete associated processes
            $order->processes()->delete();

            // Delete the order itself
            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete order: ' . __METHOD__ . ' - ' . $e->getMessage());

            return redirect()->route('orders.index')->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }



}
