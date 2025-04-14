<li class="nav-header">ADDITIONAL DOCUMENTS</li>
<li class="nav-item">
    <a href="{{ route('documents.index') }}" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Additional Documents
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('documents.index') }}"
                class="nav-link {{ request()->routeIs('documents.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>List Documents</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('documents.create') }}"
                class="nav-link {{ request()->routeIs('documents.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Document</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('documents.import') }}"
                class="nav-link {{ request()->routeIs('documents.import') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Import from Excel</p>
            </a>
        </li>
    </ul>
</li>
