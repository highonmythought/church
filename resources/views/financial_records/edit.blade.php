@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Financial Record</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('financial-records.update', $financialRecord->id) }}" method="POST">

                @csrf
                @method('PUT')

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
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control" required>
                        @foreach(['Tithe', 'Offering', 'Donation', 'Thanksgiving', 'others'] as $type)
                            <option value="{{ $type }}" {{ $financialRecord->type === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" value="{{ $financialRecord->description }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount (₦)</label>
                    <input type="number" step="0.01" name="amount" value="{{ $financialRecord->amount }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" value="{{ $financialRecord->date->format('Y-m-d') }}" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('financial-records.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
