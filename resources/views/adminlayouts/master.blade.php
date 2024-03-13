<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Set the title dynamically -->
    <title>@yield('title') - Builidng Management</title>

    <!-- Set the meta description dynamically -->
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="Builidng Management, ">
    <meta name="robots" content="index, follow"> <!-- Allow search engines to index your site -->
    <meta name="author" content="Builidng Management"> <!-- Author of the website -->
    <meta name="theme-color" content="#71C9B7"> <!-- Theme color for mobile browsers -->
    <meta name="format-detection" content="telephone=no"> <!-- Disable automatic detection of phone numbers -->

    <!-- Favicons -->
    <link href="{{ asset('assets/images/Slinqq.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS Files -->
    <link href="{{ URL::to('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('assets/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ URL::to('assets/css/admin-panel.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <!-- navbar -->
            @include('adminlayouts.partials.navbar')
            <!-- Include the sidebar -->
            @include('adminlayouts.partials.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('authenticate_content')
                </div>
            </div>

        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ URL::to('assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/off-canvas.js') }}"></script>
    <script src="{{ URL::to('assets/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ URL::to('assets/js/template.js') }}"></script>

    @yield('admin_scripts')
</body>

</html>
