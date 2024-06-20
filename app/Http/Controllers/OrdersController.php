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

        return view('admin.order.order_list',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $processes=Process::all();
        return view('admin.order.add_order',compact('processes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try{           
            $order = Order::create($request->only(
                'order_number', 'customer_name', 'customer_phone', 'customer_address', 'ordered_date', 'estimate_delivery_date', 'process_steps'
            ));

            foreach ($request->process_steps as $process_id) {
                $order->processes()->create(['process_id' => $process_id]);
            }

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
          }
        catch(\Exception $e)
        {
            Log::error('Failed to create order: '>__METHOD__. $e->getMessage());

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
        $processes=Process::all();

        return view('admin.order.edit_order', compact('order','processes'));
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
        //

        // try{   
        //     $getOrder=Order::findorFail($id);
        //     $order = Order::create($request->only(
        //         'order_number', 'customer_name', 'customer_phone', 'customer_address', 'ordered_date', 'estimate_delivery_date', 'process_steps'
        //     ));

        //     foreach ($request->process_steps as $process_id) {
        //         $order->processes()->create(['process_id' => $process_id]);
        //     }

        //     return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        //   }
        // catch(\Exception $e)
        // {
        //     Log::error('Failed to create order: '>__METHOD__. $e->getMessage());

        //     return redirect()->back()->withInput()->with('error', 'Failed to create order: ' . $e->getMessage());

        // }

        try {
            // Find the existing order by ID
            $order = Order::findOrFail($id);
    
            $order->orderProcesses()->delete();

        foreach ($request->process_steps as $key => $process_id) {
            $order->orderProcesses()->create([
                'process_id' => $process_id,
               
            ]);
            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');

        }
    
        } catch (\Exception $e) {
            Log::error('Failed to update order: ' . __METHOD__. $e->getMessage());
    
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
        //
    }
}
