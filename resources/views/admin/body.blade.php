<div class="main-panel bg-white">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif
    <div class="content-wrapper bg-white">
        <div class="row">
            <div class="bg-white p-8 rounded-lg shadow-lg  ">
                <div class="flex justify-end">
                    <a class="nav-link bg-orange-500 rounded-md " href="{{ route('admin.process') }}">
                        <button class="bg-orange-500 text-white px-4  rounded-md w-100 hover:bg-orange-600 ">
                            Add Process
                        </button>
                        
                    </a>
                </div>
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Processes List</h2>
                    
               
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/3 px-4 py-2">Process Name</th>
                            <th class="w-1/3 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($processes as $process)
                        <tr class="bg-gray-100 text-black">
                            <td class="border px-4 py-2">{{ $process->name }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.edit_process',$process->id) }}" class="text-white text-decoration-none">
                                <button class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                    Edit
                                </button>
                            </a>
                                <form action="{{ route('admin.delete_process',$process->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">Delete</button>
                                </form>
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
</div>
