<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Order</h2>
                        
                        <form action="{{ route('orders.store') }}" method="post">
                            @csrf
                            
                            <!-- Order Number -->
                            {{-- <div class="mb-4">
                                <label for="order_number" class="block text-gray-700 text-sm font-bold mb-2">Order Number</label>
                                <input type="text" id="order_number" name="order_number" placeholder="Enter order number" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('order_number')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror --}}

                            <!-- Customer Name -->
                            <div class="mb-4">
                                <label for="customer_name" class="block text-gray-700 text-sm font-bold mb-2">Customer Name</label>
                                <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer name" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('customer_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Customer Phone -->
                            <div class="mb-4">
                                <label for="customer_phone" class="block text-gray-700 text-sm font-bold mb-2">Customer Phone</label>
                                <input type="text" id="customer_phone" name="customer_phone" placeholder="Enter customer phone" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('customer_phone')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Customer Address -->
                            <div class="mb-4">
                                <label for="customer_address" class="block text-gray-700 text-sm font-bold mb-2">Customer Address</label>
                                <input type="text" id="customer_address" name="customer_address" placeholder="Enter customer address" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('customer_address')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Ordered Date -->
                            <div class="mb-4">
                                <label for="ordered_date" class="block text-gray-700 text-sm font-bold mb-2">Ordered Date</label>
                                <input type="date" id="ordered_date" name="ordered_date" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('ordered_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Estimate Delivery Date -->
                            <div class="mb-4">
                                <label for="estimate_delivery_date" class="block text-gray-700 text-sm font-bold mb-2">Estimate Delivery Date</label>
                                <input type="date" id="estimate_delivery_date" name="estimate_delivery_date" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('estimate_delivery_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Process Steps -->
                            <div class="mb-4">
                                <label for="process_steps" class="block text-gray-700 text-sm font-bold mb-2">Process Steps</label>
                                <select name="process_steps[]" id="process_steps" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" multiple required>
                                    @foreach($processes as $process)
                                        <option value="{{ $process->id }}">{{ $process->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('process_steps')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white font-bold p-2 rounded">
                                    Create Order
                                </button>
                                <a href="{{ route('orders.index') }}">
                                    <button type="button"
                                        class="bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded">
                                        Go Back
                                    </button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
