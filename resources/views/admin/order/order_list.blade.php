<x-app-layout>

    <div class="main-panel bg-white">
      
        <div class="content-wrapper bg-white">
          
            <div class="row">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-12" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
            
                @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 mt-12" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <div class="flex justify-end mt-12">
                <a href="{{ route('orders.create') }}" class="bg-orange-500 text-white px-3 py-2 rounded hover:bg-orange-600">
                    Add Order
                </a>
                
                
            </div>
                    <h2 class="text-2xl font-bold mb-6 text-gray-800 mt-5">Orders List</h2>
                    
                    
    
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-2">Order Number</th>
                                <th class="px-4 py-2">Customer Name</th>
                                <th class="px-4 py-2">Customer Phone</th>
                                <th class="px-4 py-2">Customer Address</th>
                                <th class="px-4 py-2">Ordered Date</th>
                                <th class="px-4 py-2">Estimate Delivery Date</th>
                                <th class="px-4 py-2">Process Steps</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="bg-gray-100 text-center text-black">
                                <td class="border">{{ $order->order_number }}</td>
                                <td class="border">{{ $order->customer_name }}</td>
                                <td class="border">{{ $order->customer_phone }}</td>
                                <td class="border">{{ $order->customer_address }}</td>
                                <td class="border">{{ $order->ordered_date }}</td>
                                <td class="border">{{ $order->estimate_delivery_date }}</td>
                                <td>
                                    @foreach($order->processes as $process)
                                        {{ $process->process->name }},
                                    @endforeach
                                </td>
    
    
                                <td class=" flex gap-2 border px-4 py-2">
                                    <a href="{{ route('orders.edit',$order->id) }}" class="text-white text-decoration-none">
                                    <button class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                        Edit
                                    </button>
                                </a>
                                    <form action="{{ route('orders.destroy',$order->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                
            </div>
      
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
    
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    </x-app-layout>
    