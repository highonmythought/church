@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Event</h3>

    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Event Type</label>
            <select name="event_type" class="form-select" required>
                <option value="Sunday Service" {{ $event->event_type == 'Sunday Service' ? 'selected' : '' }}>Sunday Service</option>
                <option value="Weekly Service" {{ $event->event_type == 'Weekly Service' ? 'selected' : '' }}>Weekly Service</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $event->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="{{ $event->date->format('Y-m-d') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="time" value="{{ $event->time }}" class="form-control">
        </div>

       <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
</form>
</div>
@endsection
