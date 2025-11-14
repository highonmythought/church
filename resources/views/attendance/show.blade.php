@extends('layouts.app')

@section('content')
<h3>Attendance Details</h3>

<div class="card p-3">
    <p><strong>Event:</strong> {{ $attendance->event->event_type ?? '—' }}</p>
    <p><strong>Date:</strong> {{ $attendance->date->format('Y-m-d') }}</p>
    <p><strong>Total Attendance:</strong> {{ $attendance->total_attendance }}</p>
</div>

<a href="{{ route('attendance.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
