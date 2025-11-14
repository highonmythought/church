@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Event</h3>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Event Type</label>
            <select name="event_type" class="form-select" required>
                <option value="">Select event type</option>
                <option value="Sunday Service">Sunday Service</option>
                <option value="Weekly Service">Weekly Service</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Optional description"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="time" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Event</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
