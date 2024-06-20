<x-app-layout>
  

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900 ">
                    
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Process</h2>
                
                        <form action="{{ route('admin.update_process',$process->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Process Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Process Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter process name" value="{{ $process->name }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="flex space-x-4">
                            
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold p-2 rounded focus:outline-none focus:shadow-outline">
                                    update
                                </button>                             
                                <a href="{{ route('home') }}">
                                    <button type="button"
                                        class="bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded ">
                                        Go Back
                                    </button></a>
                            </div>
                                
                               

                            </div>

                        </form>
                       
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>