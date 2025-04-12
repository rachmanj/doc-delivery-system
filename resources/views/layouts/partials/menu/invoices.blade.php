<li class="nav-header">INVOICES</li>
<li class="nav-item">
    <a href="{{ url('invoices') }}" class="nav-link {{ Request::is('invoices*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-id-badge"></i>
        <p>
            Manage Invoices
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('invoices/dashboard') }}" class="nav-link {{ Request::is('invoices/dashboard*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-compass"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
