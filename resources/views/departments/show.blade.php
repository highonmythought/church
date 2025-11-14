@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Department Details</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $departments->name }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $departments->description ?? 'No description provided.' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('departments.edit', $departments->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
