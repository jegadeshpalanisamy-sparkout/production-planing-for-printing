<x-app-layout>
    <div class="container mx-auto pt-12 px-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 mt-12">Employee Filter</h1>

        <div class="flex space-x-4 mb-6 justify-end">
            <div class="flex gap-2">
                <h2 class="underline ">Filters:</h2>
                <select name="employee_name" id="employee_name"
                    class="mt-2 text-sm md:mt-0 md:ml-4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-40">
                    <option value="">-Employee name-</option>
                    @foreach ($getEmployees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <select name="order_number" id="order"
                    class="mt-2 text-sm md:mt-0 md:ml-4 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-40">
                    <option value="">-Select order-</option>
                    @foreach ($getOrders as $order)
                        <option value="{{ $order->id }}">{{ $order->order_number }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="button" id="filterBtn"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table id="filterResults" class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-2/12 px-4 py-2">Employee Name</th>
                        <th class="w-2/12 px-4 py-2">Order Number</th>
                        <th class="w-2/12 px-4 py-2">Process</th>
                        <th class="w-3/12 px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Populate table rows with AJAX response --}}
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#filterBtn').on('click', function() {
            var employeeId = $('#employee_name').val();
            var orderId = $('#order').val();

            $.ajax({
                url: "{{ route('admin.emp_order_search') }}",
                type: 'GET',
                data: {
                    employeeId: employeeId,
                    orderId: orderId
                },
                success: function(response) {
                    console.log(response);

                    var tableBody = $('#filterResults tbody');
                    tableBody.empty();

                    // Iterate through each order process in response.data
                    $.each(response.data, function(index, orderProcess) {
                        var newRow = `
                            <tr class="text-center">
                                <td class="px-4 py-2">${orderProcess.employee ? orderProcess.employee.emp_name : ''}</td>
                                <td class="px-4 py-2">${orderProcess.order ? orderProcess.order.order_number : ''}</td>
                                <td class="px-4 py-2">${orderProcess.process ? orderProcess.process.name : ''}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    ${orderProcess.process && orderProcess.end_time ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                    ${orderProcess.process && orderProcess.end_time ? 'completed' : 'pending'}
                                    </span>
                                </td>
                            </tr>`;

                        tableBody.append(newRow);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
