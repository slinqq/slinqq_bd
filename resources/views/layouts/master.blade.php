<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Set the title dynamically -->
    <title>@yield('title') - Building Management</title>

    <!-- Set the meta description dynamically -->
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="Building Management, ">
    <meta name="robots" content="index, follow"> <!-- Allow search engines to index your site -->
    <meta name="author" content="Building Management"> <!-- Author of the website -->
    <meta name="theme-color" content="#71C9B7"> <!-- Theme color for mobile browsers -->
    <meta name="format-detection" content="telephone=no"> <!-- Disable automatic detection of phone numbers -->

    <!-- Open Graph Meta Tags (for social media sharing) -->
    <meta property="og:title" content="Building Management">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="{{ asset('assets/images/last.png') }}"> <!-- URL to an image to display when sharing on social media -->
    <meta property="og:type" content="website">

    <!-- Twitter Meta Tags (for Twitter sharing) -->
    <meta name="twitter:card" content="{{ asset('assets/images/last.png') }}">
    <meta name="twitter:title" content="Building Management Limited">
    <meta name="twitter:description" content="@yield('description')">
    <meta name="twitter:image" content="{{ asset('assets/images/last.png') }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/images/last.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS Files -->
    <link href="{{ URL::to('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ URL::to('assets/bootstrap-icons.css') }}" rel="stylesheet"> -->
    <link href="{{ URL::to('assets/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ URL::to('assets/css/main.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>

    <!-- ======= Navbar ======= -->
    @include('layouts.navbar')
    <!-- End Navbar -->

    <main>

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <!-- End Footer -->
    <footer class="site-footer">
        @include('layouts.footer')
    </footer>
    <!-- End Footer -->

    <!-- Your other content goes here -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- <div id="preloader"></div> -->

    <!-- Vendor JS Files -->
    <script src="{{ URL::to('assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/jquery.sticky.js') }}"></script>
    <!-- <script src="{{ URL::to('assets/js/click-scroll.js') }}"></script> -->
    <!-- <script src="{{ URL::to('assets/js/counter.js') }}"></script> -->

    <!-- Main JS File -->
    <script src="{{ URL::to('assets/js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>