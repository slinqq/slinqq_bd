<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @hasrole('superadmin')
        <li class="nav-item {{ request()->is('superadmin*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('superadmin') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">All Admins</span>
            </a>
        </li>
        @endhasrole
        @hasrole('admin|manager')
        <li class="nav-item {{ !request()->is('superadmin*') && !request()->is('buildings/managers') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('companies') }}">
                <i class="mdi mdi-bank menu-icon"></i>
                <span class="menu-title">Buildings</span>
            </a>
        </li>
        @endhasrole
        @hasrole('admin')
        <li class="nav-item {{ request()->is('buildings/managers') ? 'active' : '' }}">
            <a class="nav-link " href="{{ route('managers') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Manager</span>
            </a>
        </li>
        @endhasrole
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="mdi mdi-logout menu-icon text-danger"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>
    </ul>
</nav>
