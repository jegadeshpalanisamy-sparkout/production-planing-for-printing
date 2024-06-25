{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

{{-- <x-app-layout>
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
        <div class="container-scroller">

            <!-- partial:partials/_sidebar.html -->


            <!-- partial -->
            <div class="container-fluid page-body-wrapper">

            </div>

        </div>
        <!-- container-scroller -->
        @include('admin.script')
        <!-- plugins:js -->

        <!-- End custom js for this page -->
    </body>

    </html>
</x-app-layout> --}}

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
        <div class="container-scroller flex flex-col md:flex-row ">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <div class="flex-1 p-6 bg-gray-100 pt-12">
                <div class="container mx-auto pt-12">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tightpt-12">
                        {{ __('All Notifications') }}
                    </h2>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    @forelse ($getNotifications as $notification)
                                        <div class="flex justify-between text-gray-900 dark:text-gray-800">
                                            <div>
                                                <p>{{ $notification->data['message']}}</p>
                                                <p>{{'Order number:' . $notification->data['order_number']}}</p>
                                                <p> {{'Process stage:'.$notification->data['process_id'] }}</p>
                                                
                                                <p class="bg-blue-500">
                                                    {{ $notification->read_at ? '' : 'new notification' }}</p>
                                             </div>
                                            <p>{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>

                                    @empty
                                        <p class="text-white p-2">There is no notification</p>
                                    @endforelse
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ auth()->user()->notifications->where('notifiable_id',Auth::id())->markAsRead() }}
        


        @include('admin.script')
    </body>

    </html>
</x-app-layout>
