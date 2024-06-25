<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-2xl">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Order</h2>
                        <form action="{{ route('orders.update', $order->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <!-- Customer Name -->
                            <div class="mb-4">
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer
                                    Name</label>
                                <input type="text" name="customer_name" id="customer_name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm "
                                    value="{{ $order->customer_name }}" required>
                            </div>

                            <!-- Customer Phone -->
                            <div class="mb-4">
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700">Customer
                                    Phone</label>
                                <input type="text" name="customer_phone" id="customer_phone"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm "
                                    value="{{ $order->customer_phone }}" required>
                            </div>

                            <!-- Customer Address -->
                            <div class="mb-4">
                                <label for="customer_address" class="block text-sm font-medium text-gray-700">Customer
                                    Address</label>
                                <input type="text" name="customer_address" id="customer_address"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm "
                                    value="{{ $order->customer_address }}" required>
                            </div>

                            <!-- Ordered Date -->
                            <div class="mb-4">
                                <label for="ordered_date" class="block text-sm font-medium text-gray-700">Ordered
                                    Date</label>
                                <input type="date" name="ordered_date" id="ordered_date"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm "
                                    value="{{ $order->ordered_date }}" required>
                            </div>

                            <!-- Estimate Delivery Date -->
                            <div class="mb-4">
                                <label for="estimate_delivery_date"
                                    class="block text-sm font-medium text-gray-700">Estimate Delivery Date</label>
                                <input type="date" name="estimate_delivery_date" id="estimate_delivery_date"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm "
                                    value="{{ $order->estimate_delivery_date }}" required>
                            </div>

                            <!-- Process Steps -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Process Steps</label>
                                @foreach ($processes as $process)
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" name="process_steps[]"
                                            id="process_step_{{ $process->id }}" value="{{ $process->id }}"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded addcheck" >
                                        <label for="process_step_{{ $process->id }}"
                                            class="ml-2 text-sm text-gray-600">{{ $process->name }}</label>
                                    </div>
                                @endforeach
                            </div>


                            <!-- Hidden Input to Store Selection Order -->
                            <input type="hidden" name="process_steps_order" id="process_steps_order">

                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white font-bold p-2 rounded">
                                    Update
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

        <script>
            $(document).ready(function() {
                var selectedProcessSteps = [];
                $('.addcheck').change(function() {

                    let temp = [];
                    // Loop through all checked checkboxes
                    $('.addcheck:checked').each(function() {
                        temp.push($(this).val());
                        if (!selectedProcessSteps.includes($(this).val())) {
                            selectedProcessSteps.push($(this).val());
                        }
                    });

                    for (let i = selectedProcessSteps.length - 1; i >= 0; i--) {
                        if (!temp.includes(selectedProcessSteps[i])) {
                            selectedProcessSteps = selectedProcessSteps.filter((a) => a != selectedProcessSteps[
                                i]);
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
