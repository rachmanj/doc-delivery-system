<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-dark navbar-light fixed-top py-1 px-1">
    <div class="container-fluid px-2">
        <a href="#"class="navbar-brand">
            <span class="brand-text text-white font-weight-light"><strong>DD</strong> System</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
            </li>

            @include('layouts.partials.menu.invoices')

            @include('layouts.partials.menu.additional-documents')

            @include('layouts.partials.menu.deliveries')

            <!-- Dropdown Settings (with merged Master items) -->
            @hasanyrole(['admin', 'superadmin'])
                @include('layouts.partials.menu.settings')
            @endhasanyrole
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Profile Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{-- <i class="fas fa-user-circle"></i> --}}
                    <span class="ml-2">{{ auth()->user()->name }}
                        ({{ auth()->user()->department->location_code }})</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="fas fa-key mr-2"></i> Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
<!-- /.navbar -->
