@extends('layouts.app')

@section('content')

<div class="container mt-4">


<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Roles & Permissions Management</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tabs -->
<ul class="nav nav-tabs mb-4" id="rolesTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="manage-tab" data-bs-toggle="tab" data-bs-target="#manage" type="button" role="tab">
            <i class="fas fa-tools me-1"></i> Manage
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
            <i class="fas fa-chart-pie me-1"></i> Overview
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab">
            <i class="fas fa-database me-1"></i> Current Data
        </button>
    </li>
</ul>

<div class="tab-content" id="rolesTabsContent">

    <!-- Manage Tab -->
    <div class="tab-pane fade show active" id="manage" role="tabpanel">
        <div class="row g-4">

            <!-- Create Role -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white fw-bold">Create Role</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('roles.store') }}">
                            @csrf
                            <input type="text" name="name" class="form-control mb-3" placeholder="Role name" required>
                            <button class="btn btn-primary w-100">Add Role</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Create Permission -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white fw-bold">Create Permission</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('permissions.store') }}">
                            @csrf
                            <input type="text" name="name" class="form-control mb-3" placeholder="Permission name" required>
                            <button class="btn btn-success w-100">Add Permission</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Assign Role / Permission -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-warning text-white fw-bold">Assign Role / Permission</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('roles.assign') }}" class="mb-3">
                            @csrf
                            <select name="user_id" class="form-select mb-2" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                            <select name="role" class="form-select mb-3" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-warning w-100">Assign Role</button>
                        </form>

                        <form method="POST" action="{{ route('permissions.assign') }}">
                            @csrf
                            <select name="user_id" class="form-select mb-2" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                            <select name="permission" class="form-select mb-3" required>
                                <option value="">Select Permission</option>
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-dark w-100">Assign Permission</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Overview Tab -->
    <div class="tab-pane fade" id="overview" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-2"><i class="fas fa-user-shield text-primary me-2"></i>Roles</h5>
                        <p class="fs-5">{{ \Spatie\Permission\Models\Role::count() }} Total</p>
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">
                            View All Roles
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-2"><i class="fas fa-key text-success me-2"></i>Permissions</h5>
                        <p class="fs-5">{{ \Spatie\Permission\Models\Permission::count() }} Total</p>
                        <a href="{{ route('permissions.index') }}" class="btn btn-outline-success">
                            View All Permissions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Data Tab -->
    <div class="tab-pane fade" id="current" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">Current Roles, Permissions & Users</div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h5 class="fw-bold">Roles</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($roles as $role)
                                <li class="list-group-item">{{ $role->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h5 class="fw-bold">Permissions</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($permissions as $permission)
                                <li class="list-group-item">{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h5 class="fw-bold">Users</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($users as $user)
                                <li class="list-group-item">
                                    {{ $user->name }} — 
                                    <strong>Roles:</strong> {{ $user->roles->pluck('name')->join(', ') ?: 'None' }} |
                                    <strong>Permissions:</strong> {{ $user->permissions->pluck('name')->join(', ') ?: 'None' }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</div>
@endsection
