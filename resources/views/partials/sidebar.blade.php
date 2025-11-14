<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-church"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Church Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Welcome</span>
        </a>
    </li>

    @if(auth()->user()->hasRole('Admin')) <!-- Divider --> <hr class="sidebar-divider">


<!-- Roles & Permissions -->
<div class="sidebar-heading">
    Administration
</div>

<li class="nav-item {{ Route::is('roles.*') || Route::is('permissions.*') || Route::is('roles_permissions.*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRolesPermissions" aria-expanded="true" aria-controls="collapseRolesPermissions">
        <i class="fas fa-user-lock"></i>
        <span>Roles & Permissions</span>
    </a>
    <div id="collapseRolesPermissions" class="collapse {{ Route::is('roles.*') || Route::is('permissions.*') || Route::is('roles_permissions.*') ? 'show' : '' }}" aria-labelledby="headingRolesPermissions" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Route::is('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">View Roles</a>
            <a class="collapse-item {{ Route::is('permissions.index') ? 'active' : '' }}" href="{{ route('permissions.index') }}">View Permissions</a>
            <a class="collapse-item {{ Route::is('roles_permissions.index') ? 'active' : '' }}" href="{{ route('roles_permissions.index') }}">Manage Role Permissions</a>
        </div>
    </div>
</li>


@endif

    

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- People Section -->
    <div class="sidebar-heading">
        People
    </div>

    <li class="nav-item {{ Route::is('members.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('members.index') }}">
            <i class="fas fa-user-friends"></i>
            <span>Members</span>
        </a>
    </li>
 <li class="nav-item">
    <a class="nav-link" href="{{ route('expenses.summary') }}">
        <i class="fas fa-chart-bar"></i>
        <span>Expense Summary</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('expenses.index') }}">
        <i class="fas fa-chart-bar"></i>
        <span>Expense</span>
    </a>
</li>
    <li class="nav-item {{ Route::is('pastors.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pastors.index') }}">
            <i class="fas fa-user-tie"></i>
            <span>Pastors</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('departments.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('departments.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Departments</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Worship & Events -->
    <div class="sidebar-heading">
        Worship & Events
    </div>

    <li class="nav-item {{ Route::is('events.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('events.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('attendance.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('attendance.index') }}">
            <i class="fas fa-clipboard-check"></i>
            <span>Attendance</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('sermons.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sermons.index') }}">
            <i class="fas fa-book-bible"></i>
            <span>Sermons</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Finance -->
    <div class="sidebar-heading">
        Finance
    </div>

    <li class="nav-item {{ Route::is('financial-records.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('financial-records.index') }}">
            <i class="fas fa-donate"></i>
            <span>Financial Records</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('pledges.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pledges.index') }}">
            <i class="fas fa-hand-holding-heart"></i>
            <span>Pledges</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Assets -->
    <div class="sidebar-heading">
        Assets
    </div>

    <li class="nav-item {{ Route::is('equipments.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('equipments.index') }}">
            <i class="fas fa-boxes"></i>
            <span>Equipments</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>


</ul>