<x-app-layout>

    <div class="main-panel bg-white">

        <div class="content-wrapper bg-white">

            <div class="row">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-12"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 mt-12"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-end mt-12">
                        <a href="{{ route('admin.assign_order') }}"
                            class="bg-orange-500 text-white px-3 py-2 rounded hover:bg-orange-600">
                            Assign new Order
                        </a>


                    </div>
                    <h2 class="text-2xl font-bold mb-6 text-gray-800 mt-5">Assign Order List</h2>



                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class=" px-4 py-2">order_number</th>
                                <th class=" px-4 py-2">Process</th>
                                <th class=" px-4 py-2">Employee Name</th>
                                <th class=" px-4 py-2">status</th>
                                <th class=" px-4 py-2">Spend time</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getAssignOrders as $assign)
                                <tr class="bg-gray-100 text-center text-black">
                                    <td class="border  px-4 py-2">{{ $assign->order->order_number }}</td>
                                    <td class="border  px-4 py-2">{{ $assign->process->name }}</td>
                                    <td class="border  px-4 py-2">{{ $assign->employee->emp_name }}</td>
                                    <td
                                        class="{{ $assign->end_time == null ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} border  px-4 py-2">
                                        {{ $assign->end_time == null ? 'in-progress' : 'completed' }}</td>
                                    <td
                                        class="{{ $assign->end_time == null ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} border  px-4 py-2">
                                        @if ($assign->end_time != null)
                                            {{ $assign->end_time->diffForHumans($assign->start_time, true) }}
                                        @else
                                            {{ 'still working' }}
                                        @endif

                                    </td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>

            </div>

        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->

</x-app-layout>
