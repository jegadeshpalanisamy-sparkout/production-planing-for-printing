<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Order</h2>

                        <form action="{{ route('orders.store') }}" method="post" id="orderForm">
                            @csrf

                            <!-- Customer Name -->
                            <div class="mb-4">
                                <label for="customer_name" class="block text-gray-700 text-sm font-bold mb-2">Customer
                                    Name</label>
                                <input type="text" id="customer_name" name="customer_name" 
                                    placeholder="Enter customer name" value="{{ old('customer_name') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('customer_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Customer Phone -->
                            <div class="mb-4">
                                <label for="customer_phone" class="block text-gray-700 text-sm font-bold mb-2">Customer
                                    Phone</label>
                                <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                                    placeholder="Enter customer phone"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('customer_phone')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Customer Address -->
                            <div class="mb-4">
                                <label for="customer_address"
                                    class="block text-gray-700 text-sm font-bold mb-2">Customer Address</label>
                                <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address') }}"
                                    placeholder="Enter customer address"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('customer_address')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Ordered Date -->
                            <div class="mb-4">
                                <label for="ordered_date" class="block text-gray-700 text-sm font-bold mb-2">Ordered
                                    Date</label>
                                <input type="date" id="ordered_date" name="ordered_date" value="{{ old('ordered_date') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('ordered_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Estimate Delivery Date -->
                            <div class="mb-4">
                                <label for="estimate_delivery_date"
                                    class="block text-gray-700 text-sm font-bold mb-2">Estimate Delivery Date</label>
                                <input type="date" id="estimate_delivery_date" name="estimate_delivery_date" value="{{ old('estimate_delivery_date') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('estimate_delivery_date')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Process Steps -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Process Steps</label>
                                @foreach ($processes as $process)
                                    <div class="mb-2">
                                        <input type="checkbox" name="process_steps[]"
                                            id="process_step_{{ $process->id }}" class="addcheck"
                                            value="{{ $process->id }}" {{ in_array($process->id, old('process_steps', [])) ? 'checked' : '' }}
                                            class="shadow border rounded py-2 px-3 text-gray-700 leading-tight">
                                        <label for="process_step_{{ $process->id }}"
                                            class="ml-2">{{ $process->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('process_steps')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Hidden Input to Store Selection Order -->
                            <input type="hidden" name="process_steps_order" id="process_steps_order">

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
    <script>
        $(document).ready(function() {
            var selectedProcessSteps = [];
            $('.addcheck').change(function() {

                let temp = [];
                // Loop through all checked checkboxes
                $('.addcheck:checked').each(function() {
                    temp.push($(this).val());
                    if (!selectedProcessSteps.includes($(this).val())) { // check this value have in selectedProcessSteps if not there it will be added
                        selectedProcessSteps.push($(this).val());
                    }
                });

                for (let i = selectedProcessSteps.length - 1; i >= 0; i--) {
                    if (!temp.includes(selectedProcessSteps[i])) {
                        selectedProcessSteps = selectedProcessSteps.filter((a) => a != selectedProcessSteps[i]);
                    }
                }
                // console.log(selectedProcessSteps)

                // Update hidden input value with JSON-encoded array
                $('#process_steps_order').val(JSON.stringify(selectedProcessSteps));
                
                console.log($('#process_steps_order').val()); // Check hidden input value
            });
        });
    </script>

</x-app-layout>
