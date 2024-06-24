<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Order Amount</h2>
                        <form action="{{ route('admin.update_bill',$getBill->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Order ID Selection Dropdown -->
                            <div class="mb-4">
                                <label for="order_select" class="block text-sm font-medium text-gray-700">Select Order</label>
                                <select id="order_select" name="order_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Select Order --</option>
                                    @foreach ($getOrders as $order)
                                        <option value="{{ $order->id }}" {{ $order->id == $getBill->order_id ? 'selected' : '' }}>
                                            {{ $order->order_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Amount Input -->
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" id="amount" name="amount" value="{{ $getBill->amount }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
                                @error('amount')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                    Update
                                </button>

                                <a href="{{ route('admin.bill_index') }}">
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
