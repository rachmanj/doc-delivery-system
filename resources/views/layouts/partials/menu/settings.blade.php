<li class="nav-item dropdown">
    <a id="dropdownApprovals" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="nav-link dropdown-toggle">Settings</a>

    <ul aria-labelledby="dropdownApprovals" class="dropdown-menu border-0 shadow">
        <!-- Master Data Items -->
        <h6 class="dropdown-header">Master Data</h6>
        <a class="dropdown-item" href="{{ url('master/projects') }}">Projects</a>
        <a class="dropdown-item" href="{{ url('master/suppliers') }}">Suppliers</a>
        <a class="dropdown-item" href="{{ url('master/departments') }}">Departments</a>
        <a class="dropdown-item" href="{{ url('master/invoice-types') }}">Invoice Types</a>
        <a class="dropdown-item" href="{{ url('master/additional-document-types') }}">Document Types</a>
        <div class="dropdown-divider"></div>
        <!-- Settings Items -->
        <h6 class="dropdown-header">Administration</h6>
        <a class="dropdown-item" href="{{ url('settings/users') }}">Users</a>
        <a class="dropdown-item" href="{{ url('settings/roles') }}">Roles</a>
        <a class="dropdown-item" href="{{ url('settings/permissions') }}">Permissions</a>
    </ul>
</li>
