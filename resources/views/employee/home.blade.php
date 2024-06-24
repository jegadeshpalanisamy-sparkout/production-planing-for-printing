
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
            <x-sidebar/>

            <!-- Main Content -->
            <div class="flex-1 p-6 bg-gray-100">
                <div class="container mx-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('User page') }}
                    </h2>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.script')
    </body>

    </html>
</x-app-layout>

