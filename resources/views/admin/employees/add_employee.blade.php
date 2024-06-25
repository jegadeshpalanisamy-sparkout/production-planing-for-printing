<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Employee</h2>
                        
                        <form action="{{ route('admin.store_employee') }}" method="post">
                            
                            @csrf
                            
                            <!-- Employee Name -->
                            <div class="mb-4">
                                <label for="emp_name" class="block text-gray-700 text-sm font-bold mb-2">Employee Name</label>
                                <input type="text" id="emp_name" name="emp_name" placeholder="Enter employee name" value="{{ old('emp_name') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight  focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            @error('emp_name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                                <input type="number" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('phone')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                <input type="email" id="email" name="email" placeholder="Enter email"  value="{{ old('email') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('email')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <!-- Password -->
                            <div class="mb-6">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                                <input type="password" id="password" name="password" placeholder="Enter password" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700  leading-tight ">
                            </div>
                            @error('password')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            
                            {{-- confrim password --}}
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            </div>
                            @error('password_confirmation')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white font-bold p-2 rounded ">
                                    Save
                                </button>
                               
                                <a href="{{ route('admin.show_employees') }}">
                                    <button type="button"
                                        class="bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded ">
                                        Go Back
                                    </button></a>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
