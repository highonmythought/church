@extends('layouts.app')

@section('content')
<h3>Pastor Details</h3>

<div class="card p-3">
    <p><strong>Name:</strong> {{ $pastor->name }}</p>
    <p><strong>Rank:</strong> {{ $pastor->rank }}</p>
    <p><strong>Email:</strong> {{ $pastor->email ?? '—' }}</p>
    <p><strong>Phone:</strong> {{ $pastor->phone ?? '—' }}</p>
</div>

<a href="{{ route('pastors.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
