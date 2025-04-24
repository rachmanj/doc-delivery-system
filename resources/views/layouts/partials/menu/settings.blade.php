<li class="nav-item dropdown">
    <a id="dropdownApprovals" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="nav-link dropdown-toggle">Settings</a>

    <ul aria-labelledby="dropdownApprovals" class="dropdown-menu border-0 shadow">
        <!-- Master Data Items -->
        <h6 class="dropdown-header">Master Data</h6>
        <a class="dropdown-item" href="{{ route('master.projects.index') }}">Projects</a>
        <a class="dropdown-item" href="{{ route('master.suppliers.index') }}">Suppliers</a>
        <a class="dropdown-item" href="{{ route('master.departments.index') }}">Departments</a>
        <a class="dropdown-item" href="{{ route('master.invoice-types.index') }}">Invoice Types</a>
        <a class="dropdown-item" href="{{ route('master.additional-document-types.index') }}">Document Types</a>
        <div class="dropdown-divider"></div>
        <!-- Settings Items -->
        <h6 class="dropdown-header">Administration</h6>
        <a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
        <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
        <a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a>
    </ul>
</li>
