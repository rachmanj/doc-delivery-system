<body class="hold-transition sidebar-mini pace-primary layout-navbar-fixed layout-fixed">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            {{-- <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/contact') }}" class="nav-link">Contact</a>
            </li> --}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Profile Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-2">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>{{ auth()->user()->name }}</strong>
                        <div class="text-muted small">{{ auth()->user()->project }}</div>
                        <div class="text-muted small">{{ auth()->user()->department->name }}</div>
                    </div>
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
            {{-- <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li> --}}
        </ul>
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
    <!-- /.navbar -->
