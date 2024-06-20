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
    <div class="container-scroller">
       
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
       
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          @include('admin.body')
        </div>

    </div>
    <!-- container-scroller -->
    @include('admin.script')
    <!-- plugins:js -->

    <!-- End custom js for this page -->
</body>

</html>
</x-app-layout>
