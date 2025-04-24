<!DOCTYPE html>
<html lang="en">

{{-- HEAD --}}
@include('layouts.partials.head')

<body class="hold-transition layout-top-nav layout-navbar-fixed">

    <div class="wrapper">
        @include('layouts.partials.navbar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left: 0;">

            {{-- CONTENT --}}
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('layouts.partials.footer')
    </div>

    @include('layouts.partials.scripts')

</body>

</html>
