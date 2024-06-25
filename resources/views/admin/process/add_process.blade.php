<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-12">
                <div class="p-6 text-gray-900 ">


                    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Process</h2>

                        <form action="{{ url('store-process-admin') }}" method="post">
                            @csrf
                            <!-- Process Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Process
                                    Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter process name" value="{{ old('name') }}"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                            </div>

                            @error('name')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror

                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white font-bold p-2 rounded focus:outline-none focus:shadow-outline">
                                    Create
                                </button>
                                <a href="{{ route('home') }}">
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
