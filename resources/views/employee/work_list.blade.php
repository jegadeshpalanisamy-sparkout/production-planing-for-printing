<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <style type="text/css">
            label {
                display: inline;
                width: 200px;
            }
        </style>
        @include('admin.css')
    </head>

    <body>
        <div class="container-scroller flex flex-col md:flex-row">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <div class="flex-1 p-6 bg-gray-100">
                <div class="container mx-auto">

                    <div class="">

                        <div class="row">
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
                              
                                <h2 class="text-2xl font-bold mb-6 text-gray-800 mt-5">Orders List</h2>

                                <table class="min-w-full bg-white text-center">
                                    <thead class="bg-gray-800 text-white">
                                        <tr>
                                            <th class="px-4 py-2">Order Number</th>
                                            <th class="px-4 py-2">Process</th>
                                            <th class="px-4 py-2">Action</th>
                                            <th class="px-4 py-2">Switch Process</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employeeWorks as $work)
                                            <tr class="bg-gray-100 text-center text-black">
                                                <td class="border">{{ $work->order->order_number }}</td>
                                                <td class="border">{{ $work->process->name }}</td>
                                                <td class="flex gap-2 border px-4 py-2 justify-center">
                                                    @if($work->end_time != null)
                                                        <span class="bg-green-100 text-green-800 font-semibold py-1 px-3 rounded-full border border-green-200">Work Was Completed Successfully</span>
                                                    @elseif($work->start_time)
                                                    <button class="bg-green-500 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded" id="complete_{{ $work->id }}" onclick="finished(this, {{ $work->id }})">
                                                        Done
                                                    </button>
                                                    @else
                                                    <button class="bg-orange-400 hover:bg-orange-500 text-white font-semibold py-2 px-4 rounded" id="start_{{ $work->id }}" onclick="startWork({{ $work->id }})">
                                                        Start
                                                    </button>
                                                    <button class="bg-green-500 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded" id="complete_{{ $work->id }}" onclick="finished(this, {{ $work->id }})" hidden>
                                                        Done
                                                    </button> 
                                                     @endif
                                                </td>
                                                <td class="border">
                                                    @if ($work->end_time == null && $work->start_time==null)
                                                    please start work
                                                    @elseif($work->end_time!=null && $work->start_time!=null)
                                                    <a href="{{ route('employees.switch_process',$work->order_id)}}" class="bg-violet-500 text-white px-3 py-2 rounded hover:bg-violet-600 text-decoration-none">
                                                        Switch process                                                     
                                                    </a>
                                                    @else
                                                     <span class="bg-green-100 text-green-800 font-semibold py-1 px-3 rounded-full border border-green-200">No more process</span>

                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- content-wrapper ends -->
                        <!-- partial:partials/_footer.html -->
                    </div>
                </div>
            </div>
        </div>

        @include('admin.script')

    </body>
    <script>
        function startWork(id) {
            // If work started, enable complete button
            let completeButton = document.getElementById('complete_' + id);
            let startButton=document.getElementById('start_' + id);
            completeButton.hidden = false;
            startButton.hidden=true;

            $.ajax({
                url: '/start-work',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function finished(button,id)
        {
            const td = button.closest('td');
            td.innerHTML = "<span class='bg-green-100 text-green-800 font-semibold py-1 px-3 rounded-full border border-green-200'>Work Was Completed Successfully</span>";
            
            $.ajax({
                url:'/complete-work',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id
                },
                success:function(response)
                {
                    location.reload();
                    console.log(response);
                }

            });
        }
    </script>
    </html>
</x-app-layout>
