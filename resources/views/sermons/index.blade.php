


@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4 text-gray-800">Sermons</h1>

    <!-- Add Sermon Button -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSermonModal">
        <i class="fas fa-plus-circle"></i> Add Sermon
    </button>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($sermons->isEmpty())
                <p class="text-center text-muted">No sermons recorded yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                 <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Preacher</th>
                                <th>Bible Text</th>
                                <th>Event</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sermons as $sermon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$sermon->title}}</td>
                                    <td>{{ $sermon->date->format('M d, Y') }}</td>
                                    <td>{{ $sermon->pastor ? $sermon->pastor->name : $sermon->guest_preacher }}</td>
                                    <td>{{ $sermon->bible_text ?? '—' }}</td>
                                    <td>{{ $sermon->event->event_type ?? '—' }}</td>
                                    <td>
                                        <!-- Show Modal Trigger -->
                                        <button 
                                            class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#showSermonModal{{ $sermon->id }}">
                                            View
                                        </button>

                                        <!-- Edit Modal Trigger -->
                                        <button 
                                            class="btn btn-sm btn-warning"
                                            data-toggle="modal"
                                            data-target="#editSermonModal{{ $sermon->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('sermons.destroy', $sermon) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this sermon?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Show Modal -->
                                <div class="modal fade" id="showSermonModal{{ $sermon->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title">Sermon Details</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Title:</strong> {{ $sermon->title }}</p>
                                                <p><strong>Date:</strong> {{ $sermon->date->format('M d, Y') }}</p>
                                                <p><strong>Preacher:</strong> {{ $sermon->pastor?->name ?? $sermon->guest_preacher }}</p>
                                                <p><strong>Bible Text:</strong> {{ $sermon->bible_text ?? '—' }}</p>
                                                <p><strong>Event:</strong> {{ $sermon->event->event_type ?? '—' }}</p>
                                                <p><strong>Notes:</strong><br>{{ $sermon->summary?? '—' }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editSermonModal{{ $sermon->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title">Edit Sermon</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('sermons.update', $sermon->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" value="{{ $sermon->title }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Date</label>
                                                        <input type="date" name="date" value="{{ $sermon->date->format('Y-m-d') }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                        <label>Event</label>
                        <select name="event_id" class="form-control" id="edit_event_id" required>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">
                                    {{ $event->event_type }} ({{ $event->date->format('Y-m-d') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Bible Text</label>
                                                        <input type="text" name="bible_text" value="{{ $sermon->bible_text }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">

                                                    <label for="pastor_id">Preacher (Select Pastor)</label>
                  <div class="mb-3">
                    <label class="form-label">Preacher Type</label>
                    <select id="preacherType" class="form-control" onchange="togglePreacherFields()">
                        <option value="pastor" {{ $sermon->pastor_id ? 'selected' : '' }}>Pastor</option>
                        <option value="guest" {{ $sermon->guest_preacher ? 'selected' : '' }}>Guest Preacher</option>
                    </select>
                </div>

                <div id="pastorField" class="mb-3 {{ $sermon->guest_preacher ? 'd-none' : '' }}">
                    <label class="form-label">Select Pastor</label>
                    <select name="pastor_id" class="form-control">
                        <option value="">-- Select Pastor --</option>
                        @foreach($pastors as $pastor)
                            <option value="{{ $pastor->id }}" {{ $sermon->pastor_id == $pastor->id ? 'selected' : '' }}>
                                {{ $pastor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                  
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Guest Preacher</label>
                                                        <input type="text" name="guest_preacher" value="{{ $sermon->guest_preacher }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Notes</label>
                                                        <textarea name="summary" class="form-control" rows="3">{{ $sermon->summary }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-warning text-white">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Sermon Modal -->
<div class="modal fade" id="addSermonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Sermon</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form action="{{ route('sermons.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                     <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bible Text</label>
                        <input type="text" name="bible_text" class="form-control">
                    </div>
                    <div class="mb-3">
                  <label for="pastor_id">Preacher (Select Pastor)</label>
                  <select name="pastor_id" id="pastor_id" class="form-control">
                      <option value="">-- Select Pastor --</option>
                      @foreach($pastors as $pastor)
                          <option value="{{ $pastor->id }}">{{ $pastor->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="modal-body">
                    <div class="mb-3">
                        <label for="event_id" class="form-label">Event</label>
                        <select name="event_id" id="event_id" class="form-control" required>
                            <option value="">Select Event</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->event_type ?? $event->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guest Preacher</label>
                        <input type="text" name="guest_preacher" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="summary" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Sermon</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
