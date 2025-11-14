@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Financial Record</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('financial-records.store') }}" method="POST">
                @csrf

           <div class="mb-3">
        <label>Event</label>
        <select name="event_id" class="form-control" required>
            <option value="">Select Event</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}">{{ $event->event_type }} ({{ $event->date->format('Y-m-d') }})</option>
            @endforeach
        </select>
    </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control" required>
                        <option value="">Select type</option>
                        <option value="Tithe">Tithe</option>
                        <option value="Offering">Offering</option>
                        <option value="Donation">Donation</option>
                        <option value="Thanksgiving">Thanksgiving</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount (₦)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('financial-records.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
