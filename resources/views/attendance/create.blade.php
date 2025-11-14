@extends('layouts.app')

@section('content')
<h3>Add Attendance Record</h3>

<form action="{{ route('attendance.store') }}" method="POST">
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
        <label>Date</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Total Attendance</label>
        <input type="number" name="total_attendance" class="form-control" min="0" required>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
