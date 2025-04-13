<!-- Main Sidebar Container -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        {{-- <img src="{{ asset('assets/dist/img/logo.png') }}" alt="Logo" class="brand-image mt-1 ml-4" style="width:50%"> --}}
        <span class="brand-text font-weight-light"><b>DDS</b> System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info text-center">
                <a href="#" class="d-block">{{ auth()->user()->name }} ({{ auth()->user()->project }})</a>
                <small class="text-white">{{ auth()->user()->department->name }}</small>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('/') }}"
                        class="nav-link {{ Request::is('/') || Request::is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                {{-- INVOICES --}}
                @include('layouts.partials.menu.invoices')

                {{-- ADDITIONAL DOCUMENTS --}}
                @include('layouts.partials.menu.additional-documents')

                {{-- DELIVERIES --}}
                @include('layouts.partials.menu.deliveries')

                {{-- MASTERS --}}
                @include('layouts.partials.menu.master')

                {{-- ADMINISTRATOR --}}
                @hasanyrole(['admin', 'superadmin'])
                    @include('layouts.partials.menu.settings')
                @endhasanyrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <div class="sidebar-custom">
        <button type="button" class="btn btn-block btn-danger" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt"></i>
        </button>
        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <!-- /.sidebar -->
</aside>
