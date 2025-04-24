<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Document Delivery System' }} - DDS</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('assets/fontgoogle.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- pace-progress -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/pace-progress/themes/black/pace-theme-flat-top.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Navigation menu custom styles -->
    <style>
        .navbar-dark .dropdown-menu {
            background-color: #343a40;
        }

        .navbar-dark .dropdown-item {
            color: rgba(255, 255, 255, 0.75);
        }

        .navbar-dark .dropdown-item:hover {
            color: #fff;
            background-color: #3f474e;
        }

        @media (max-width: 991.98px) {
            .navbar-nav .dropdown-menu {
                position: absolute;
            }
        }

        @media (max-width: 767.98px) {
            .navbar .navbar-nav {
                max-height: 80vh;
                overflow-y: auto;
            }
        }
    </style>

    @yield('styles')

</head>
