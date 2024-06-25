<x-app-layout>
    <div class="container mx-auto pt-12 px-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 mt-12">Orders</h1>

        <div class=" flex space-x-4 mb-6 justify-between">
            
            <div class="flex gap-2">
                <h2 class="underline">Filters:</h2>
                <a href="{{ route('admin.order_reports', ['filter' => 'all']) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    All
                </a>
                <a href="{{ route('admin.order_reports', ['filter' => 'on_time']) }}"
                    class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded">
                    On Time
                </a>
                <a href="{{ route('admin.order_reports', ['filter' => 'late']) }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Late
                </a>
            </div>
          

            </div>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-2/12 px-4 py-2">Order ID</th>
                        <th class="w-2/12 px-4 py-2">Order Number</th>
                        <th class="w-2/12 px-4 py-2">Customer Name</th>
                        <th class="w-2/12 px-4 py-2">Ordered Date</th>
                        <th class="w-3/12 px-4 py-2">Estimate Delivery Date</th>
                        <th class="w-3/12 px-4 py-2">Delivery Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border text-center">
                            <td class="w-2/12 px-4 py-2">{{ $order->id }}</td>
                            <td class="w-2/12 px-4 py-2">{{ $order->order_number }}</td>
                            <td class="w-2/12 px-4 py-2">{{ $order->customer_name }}</td>
                            <td class="w-2/12 px-4 py-2">{{ $order->ordered_date }}</td>
                            <td class="w-2/12 px-4 py-2">{{ $order->estimate_delivery_date }}</td>
                            @if ($order->processes->last()->end_time)
                                <td>
                                    @if ($order->processes->isNotEmpty())
                                        {{ \Carbon\Carbon::parse($order->processes->last()->end_time)->format('Y-m-d') }}
                                   
                                    @endif
                                </td>
                            @else
                            <td>
                               <p>still working</p>
                            </td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
