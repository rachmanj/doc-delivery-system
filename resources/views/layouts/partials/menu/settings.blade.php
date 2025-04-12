{{-- MASTER DATA --}}
<li class="nav-header">SETTINGS</li>
<li
    class="nav-item {{ Request::is('users*') || Request::is('roles*') || Request::is('permissions*') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ Request::is('users*') || Request::is('roles*') || Request::is('permissions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Users
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('users') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('roles') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>Roles</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('permissions') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-key"></i>
                <p>Permissions</p>
            </a>
        </li>
    </ul>
</li>
