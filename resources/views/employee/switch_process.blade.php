<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Switch Order Processes</h2>
                        <form action="{{ route('employees.assign_order') }}" method="POST">
                            @csrf
                            <!-- Order Selection Dropdown -->
                            <div class="mb-4">
                                <label for="order_select" class="block text-sm font-medium text-gray-700">Select
                                    Order</label>
                                <select id="order_select"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                                    name="order_id" required>

                                    @foreach ($processes as $process)
                                        <option value="{{ $process->order_id }}">{{ $process->order->order_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Processes Display Section -->
                            <div id="processes_section" class="mt-2">
                                <p>Select This Process</p>
                                @foreach ($processes as $process)
                                    <div>
                                        <input type="checkbox" name="process_id" value="{{ $process->process_id }}"
                                            class="mr-2" required>
                                        <label for="process_{{ $process->process->id }}"
                                            class="text-sm">{{ $process->process->name }}</label>
                                    </div>
                                @endforeach
                                @error('process')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Employee Selection Dropdown -->
                            <div class="mb-4 mt-2">
                                <label for="employee_select" class="block text-sm font-medium text-gray-700">Select
                                    Employee</label>
                                <select id="employee_select"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                                    name="employee_id" required>
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->emp_name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit and Back Buttons -->
                            <div class="mt-6 gap-2 flex">
                                <div>
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white font-bold p-2 rounded">
                                        Assign
                                    </button>
                                </div>
                               
                                <div>
                                    <button type="button" onclick="window.history.back()"
                                class="bg-violet-500 hover:bg-violet-600 text-white font-bold p-2 rounded">
                                Back
                            </button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

