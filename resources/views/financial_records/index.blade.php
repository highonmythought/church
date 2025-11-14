@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-gray-800">Financial Records</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addRecordModal">
            <i class="fas fa-plus-circle"></i> Add Record
        </button>
    </div>

    <!-- Financial Summary Chart -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Financial Summary</h6>
        </div>
        <div class="card-body">
            <canvas id="financialChart" height="100"></canvas>
        </div>
    </div> -->

    <!-- Financial Records Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Records</h6>
        </div>
        <div class="card-body">
            @if($financialRecords->isEmpty())
                <p class="text-center text-muted">No records found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount (₦)</th>
                                <th>Event</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financialRecords as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->date->format('Y-m-d') }}</td>
                                    <td>{{ $record->type }}</td>
                                    <td>{{ number_format($record->amount, 2) }}</td>
                                    <td>{{ $record->event->event_type ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('financial-records.edit', $record) }}" class="btn btn-sm btn-warning">Edit
                                            <!-- <i class="fas fa-edit"></i> -->
                                        </a>
                                        <a href="{{ route('financial-records.show', $record) }}" class="btn btn-sm btn-info">View
                                            <!-- <i class="fas fa-show"></i> -->
                                        </a>
                                        <form action="{{ route('financial-records.destroy', $record) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">
                                                <!-- <i class="fas fa-trash"></i> --> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Record Modal -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('financial-records.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">Add Financial Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Tithe">Tithe</option>
                                <option value="Offering">Offering</option>
                                <option value="Donation">Donation</option>
                                <option value="Thanksgiving">Thanksgiving</option>
                                <option value="Expense">Expense</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Amount (₦)</label>
                            <input type="number" name="amount" step="0.01" class="form-control" required>
                        </div>

                          <div class="col-md-6">
        <label for="event_id" class="form-label">Event</label>
              <select name="event_id" id="event_id" class="form-control" required>
                  <option value="">Select Event</option>
                  @foreach($events as $event)
                      <option value="{{ $event->id }}">{{ $event->event_type ?? $event->name }}  ({{ $event->date->format('Y-m-d') }}) {{ $event->time ?? '—' }}</option>
                  @endforeach
              </select>
    </div>


                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Description (optional)"></textarea>
                        </div>
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
@endsection
