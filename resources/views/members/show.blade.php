@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Member Details</h4>
    <a href="{{ route('members.index') }}" class="btn btn-secondary btn-sm mb-3">← Back</a>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $member->first_name }} {{ $member->last_name }}</p>
            <p><strong>Email:</strong> {{ $member->email ?? '—' }}</p>
            <p><strong>Phone:</strong> {{ $member->phone ?? '—' }}</p>
            <p><strong>Address:</strong> {{ $member->address ?? '—' }}</p>
            <p><strong>Gender:</strong> {{ $member->gender ?? '—' }}</p>
            <p><strong>Date of Birth:</strong> {{ $member->dob ? $member->dob->format('Y-m-d') : '—' }}</p>
            <p><strong>Department:</strong> {{ $member->department->name ?? '—' }}</p>
        </div>
    </div>
</div>
@endsection
