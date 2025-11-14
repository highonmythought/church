@extends('layouts.app')

@section('content')
<h3>Edit Attendance Record</h3>

<form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Event</label>
        <select name="event_id" class="form-control" required>
            @foreach($events as $event)
                <option value="{{ $event->id }}" {{ $attendance->event_id == $event->id ? 'selected' : '' }}>
                    {{ $event->event_type }} ({{ $event->date->format('Y-m-d') }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="{{ $attendance->date->format('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label>Total Attendance</label>
        <input type="number" name="total_attendance" class="form-control" value="{{ $attendance->total_attendance }}" min="0" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
