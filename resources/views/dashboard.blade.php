@extends('layouts.app')

@section('content')

<div class="container-fluid">


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Statistics Cards -->
<div class="row">

    <!-- Total Members -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-hover">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Members</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Member::count() }}</div>
            </div>
        </div>
    </div>

    <!-- Total Pastors -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-hover">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pastors</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Pastor::count() }}</div>
            </div>
        </div>
    </div>

    <!-- Total Events -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-hover">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Events</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Event::count() }}</div>
            </div>
        </div>
    </div>

    <!-- Total Pledges -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 card-hover">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pledges</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Pledge::count() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Financial Records -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow card-hover">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Financial Records</h6>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach(\App\Models\FinancialRecord::latest()->take(5)->get() as $record)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $record->type }} - {{ $record->event?->name ?? 'N/A' }}
                            <span class="badge bg-primary rounded-pill">₦{{ number_format($record->amount, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Members -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow card-hover">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">New Members</h6>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach(\App\Models\Member::latest()->take(5)->get() as $member)
                        <li class="list-group-item">{{ $member->first_name }} {{ $member->last_name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Additional Cards for Sermons and Attendance -->
<div class="row">
    <!-- Sermons -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow card-hover">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Recent Sermons</h6>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach(\App\Models\Sermon::latest()->take(5)->get() as $sermon)
                        <li class="list-group-item">{{ $sermon->title }} ({{ $sermon->pastor?->first_name ?? 'Guest' }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Attendance Placeholder -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow card-hover">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Recent Attendance</h6>
            </div>
            <div class="card-body">
                <p>Attendance summary or chart can be added here.</p>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
