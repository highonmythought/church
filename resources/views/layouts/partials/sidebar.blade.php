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

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Management</div>

    <li class="nav-item {{ Route::is('members.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('members.index') }}">
            <i class="fas fa-users"></i>
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


    <li class="nav-item {{ Route::is('events.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('events.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('attendance.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('attendance.index') }}">
            <i class="fas fa-check-circle"></i>
            <span>Attendance</span>
        </a>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
