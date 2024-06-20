<x-app-layout>

<div class="main-panel bg-white">
  
    <div class="content-wrapper bg-white">
      
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
        <div class="flex justify-end mt-12">
            <a href="{{ route('admin.add_employee') }}" class="bg-orange-500 text-white px-3 py-2 rounded hover:bg-orange-600">
                Add Employee
            </a>
            
            
        </div>
                <h2 class="text-2xl font-bold mb-6 text-gray-800 mt-5">Employee List</h2>
                
                

                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class=" px-4 py-2">Employee Name</th>
                            <th class=" px-4 py-2">Email</th>
                            <th class=" px-4 py-2">Phone Number</th>                           

                            <th class=" px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr class="bg-gray-100 text-center text-black">
                            <td class="border ">{{ $employee->emp_name }}</td>
                            <td class="border ">{{ $employee->email }}</td>
                            <td class="border ">{{ $employee->phone }}</td>


                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.edit_employee',$employee->id) }}" class="text-white text-decoration-none">
                                <button class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                    Edit
                                </button>
                            </a>
                                <form action="{{ route('admin.delete_employee',$employee->id) }}" method="POST" class="inline-block">
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
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">

    </footer>
    <!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
</x-app-layout>
