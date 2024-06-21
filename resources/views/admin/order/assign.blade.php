<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Assign Order Processes</h2>
                    
                    <!-- Order Selection Dropdown -->
                    <div class="mb-4">
                        <label for="order_select" class="block text-sm font-medium text-gray-700">Select Order</label>
                        <select id="order_select" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Order --</option>
                            @foreach($getOrderProcesses as $order)
                                <option value="{{ $order->id }}">{{ $order->order_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Processes Display Section -->
                    <div id="processes_section" class="mt-6">
                        
                        <!-- Processes will be dynamically inserted here -->
                       

                    </div>
                    {{-- employee list --}}
                    <div class="mb-4">
                        <label for="employee_select" class="block text-sm font-medium text-gray-700">Select Employee</label>
                        <select id="employee_select" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('orders.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function() {
      
        $('#order_select').on('change', function() {
            // alert('hii');
            const orderId = $(this).val();
            
            // Clear previous processes
            $('#processes_section').empty();

            // Make Ajax request to fetch processes for selected order
            $.ajax({                
                url: `/get-processes/${orderId}`, // Replace with your Laravel route URL
                method: 'GET',
                success: function(response) {
                   const processes=response.data.processes;
                    console.log(processes);
                    $('#processes_section').append(`<p>Select this process to assign</p>`);
                    processes.forEach(processObj => {
                            $('#processes_section').append(`
                             

                            <div class="flex items-center mb-2">
                                    
                                    <input type="checkbox" id="process_${processObj.process.id}" name="processes[]" value="${processObj.process.id}" class="mr-2">
                                    <label for="process_${processObj.process.id}" class="text-sm">${processObj.process.name}</label>
                                </div>

                            `);
                            
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching processes:', error);
                    
                   
                },
            
            });
        });
    });
    </script>
</x-app-layout>
