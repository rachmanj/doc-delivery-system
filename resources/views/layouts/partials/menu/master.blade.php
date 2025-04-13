<li class="nav-header">MASTERS</li>
<li class="nav-item">
    <a href="{{ url('master/suppliers') }}" class="nav-link {{ Request::is('master/suppliers*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-truck"></i>
        <p>Suppliers</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('master/projects') }}" class="nav-link {{ Request::is('master/projects*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Projects</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('master/departments') }}" class="nav-link {{ Request::is('master/departments*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Departments</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('master/additional-document-types') }}"
        class="nav-link {{ Request::is('master/additional-document-types*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Addoc Types</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('master/invoice-types') }}"
        class="nav-link {{ Request::is('master/invoice-types*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-invoice"></i>
        <p>Invoice Types</p>
    </a>
</li>
