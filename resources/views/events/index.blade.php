@extends('layouts.app')

@section('content')
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Church Events</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addEventModal">
            <i class="fas fa-plus-circle"></i> Add Event
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Event Type</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $event->event_type }}</td>
                        <td>{{ $event->description ?? '—' }}</td>
                    <td>{{ $event->date->format('Y-m-d') }}</td>
                        <td>{{ $event->time ?? '—' }}</td>
                        <td>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Event Type</label>
            <select name="event_type" class="form-select" required>
                <option value="">Select event type</option>
                <option value="Sunday Service">Sunday Service</option>
                <option value="Weekly Service">Weekly Service</option>
            </select>
        </div>

          <div class="form-group mb-3">
              <label for="description">Description</label>
              <textarea name="description" id="description" rows="3" class="form-control"></textarea>
          </div>

          <div class="form-group mb-3">
              <label for="date">Date</label>
              <input type="date" name="date" id="date" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="time">Time</label>
              <input type="time" name="time" id="time" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Event</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
