<x-app-layout>
    <div class="container mx-auto pt-12 px-6">
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
        <h1 class="text-3xl font-bold mb-6 text-gray-800 mt-12">Order Billing List</h1>

        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.billings') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                Add Bill
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/4 px-4 py-2">Order ID</th>
                        <th class="w-1/4 px-4 py-2">Order Number</th>
                        <th class="w-1/4 px-4 py-2">Customer Name</th>
                        <th class="w-1/4 px-4 py-2">Billing Amount</th>
                        <th class="w-1/4 px-4 py-2">Actions</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach($getAllBills as $bill)
                    <tr class="bg-gray-100 text-center text-black">

                        <td class="border">{{ $bill->order_id}}</td>
                        <td class="border">{{ $bill->order->order_number }}</td>
                        <td class="border">{{ $bill->order->customer_name }}</td>
                        <td class="border">{{ $bill->amount }}</td>
                        <td class="border flex gap-2 px-4 py-2">
                            <a href="{{ route('admin.edit_bill',$bill->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">Edit</a>
                            <form action=" {{ route('admin.delete_bill',$bill->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                        
                    @endforeach
                </tbody>
            </table>
            {{ $getAllBills->links() }}
        </div>
    </div>
</x-app-layout>
