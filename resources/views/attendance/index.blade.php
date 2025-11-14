@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Attendance Records</h3>
    <div>
        <a href="{{ route('attendance.chart') }}" class="btn btn-info">View Chart</a>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addAttendanceModal">
            <i class="fas fa-plus-circle"></i> Add Record
        </button>
    </div>
</div>

@if($attendances->count())
    <table class="table table-bordered table-striped align-middle">
        <thead class="bg-primary text-white">
            <tr>
                <th>#</th>
                <th>Event</th>
                <th>Date</th>
                <th>Total Attendance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->event->event_type ?? '—' }} ({{ $attendance->event->date->format('Y-m-d') ?? '—' }}) {{ $attendance->event->time ?? '—' }}</td>
                    <td>{{ $attendance->date->format('Y-m-d') ?? '—' }}</td>
                    <td>{{ $attendance->total_attendance }}</td>
                    <td>
                        <!-- View Button -->
                        <button class="btn btn-sm btn-info viewAttendanceBtn"
                                data-toggle="modal"
                                data-target="#viewAttendanceModal"
                                data-event="{{ $attendance->event->event_type ?? '—' }}"
                                data-date="{{ $attendance->date->format('Y-m-d') }}"
                                data-total="{{ $attendance->total_attendance }}">
                            View
                        </button>

                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-warning editAttendanceBtn"
                                data-toggle="modal"
                                data-target="#editAttendanceModal"
                                data-id="{{ $attendance->id }}"
                                data-eventid="{{ $attendance->event_id }}"
                                data-date="{{ $attendance->date->format('Y-m-d') }}"
                                data-total="{{ $attendance->total_attendance }}">
                            Edit
                        </button>

                        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info">No attendance records found.</div>
@endif


<!-- Add Attendance Modal -->
<div class="modal fade" id="addAttendanceModal" tabindex="-1" aria-labelledby="addAttendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addAttendanceModalLabel">Add Attendance Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
              <label for="event_id" class="form-label">Event</label>
              <select name="event_id" id="event_id" class="form-control" required>
                  <option value="">Select Event</option>
                  @foreach($events as $event)
                      <option value="{{ $event->id }}">{{ $event->event_type ?? $event->name }} ({{ $event->date->format('Y-m-d') }}) {{ $event->time ?? '—' }}</option>
                  @endforeach
              </select>
          </div>

          <div class="mb-3">
              <label for="date" class="form-label">Date</label>
              <input type="date" name="date" id="date" class="form-control" required>
          </div>

          <div class="mb-3">
              <label for="total_attendance" class="form-label">Total Attendance</label>
              <input type="number" name="total_attendance" id="total_attendance" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Record</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- View Attendance Modal (fixed: removed Blade variables) -->
<div class="modal fade" id="viewAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">View Attendance Record</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Event:</strong> <span id="viewEvent">—</span></p>
                <p><strong>Date:</strong> <span id="viewDate">—</span></p>
                <p><strong>Total Attendance:</strong> <span id="viewTotal">—</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Attendance Modal (fixed form ID + removed Blade variables) -->
<div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editAttendanceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Attendance Record</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Event</label>
                        <select name="event_id" class="form-control" id="edit_event_id" required>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {
    // Populate View Modal
    $('.viewAttendanceBtn').click(function() {
        $('#viewEvent').text($(this).data('event'));
        $('#viewDate').text($(this).data('date'));
        $('#viewTotal').text($(this).data('total'));
    });

    // Populate Edit Modal
    $('.editAttendanceBtn').click(function() {
        let id = $(this).data('id');
        let eventId = $(this).data('eventid');
        let date = $(this).data('date');
        let total = $(this).data('total');

        $('#editAttendanceForm').attr('action', '/attendance/' + id);
        $('#editAttendanceForm select[name="event_id"]').val(eventId);
        $('#editAttendanceForm input[name="date"]').val(date);
        $('#editAttendanceForm input[name="total_attendance"]').val(total);
    });
});
</script>
@endpush
