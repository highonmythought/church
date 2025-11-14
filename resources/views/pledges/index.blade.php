@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pledges</h1>

    <div class="mb-3 text-end">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addPledgeModal">
            <i class="fas fa-plus-circle"></i> Add Pledge
        </button>
    </div>

    @php
        $totalPledged = $pledges->sum('amount');
        $totalPaid = $pledges->sum('amount_paid');
        $outstanding = $totalPledged - $totalPaid;
    @endphp

    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <h6 class="text-primary mb-1">Total Pledged</h6>
                    <h4>₦{{ number_format($totalPledged, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow py-2">
                <div class="card-body">
                    <h6 class="text-success mb-1">Total Paid</h6>
                    <h4>₦{{ number_format($totalPaid, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow py-2">
                <div class="card-body">
                    <h6 class="text-danger mb-1">Outstanding</h6>
                    <h4>₦{{ number_format($outstanding, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($pledges->isEmpty())
                <p class="text-center text-muted">No pledges found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Expected Payment Date</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pledges as $pledge)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pledge->name }}</td>
                                    <td>₦{{ number_format($pledge->amount, 2) }}</td>
                                    <td>{{ $pledge->expected_payment_date ? \Carbon\Carbon::parse($pledge->expected_payment_date)->format('Y-m-d') : '—' }}</td>
                                    <td>{{ $pledge->notes ?? '—' }}</td>
                                    <td>
                                        @if($pledge->is_paid)
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pledges.edit', $pledge->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pledges.destroy', $pledge->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this pledge?')">
                                                <i class="fas fa-trash"></i>
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

<!-- Add Pledge Modal -->
<div class="modal fade" id="addPledgeModal" tabindex="-1" role="dialog" aria-labelledby="addPledgeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('pledges.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addPledgeModalLabel">Add New Pledge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group mb-3">
              <label for="name">Member Name</label>
              <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="amount">Amount (₦)</label>
              <input type="number" name="amount" id="amount" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="expected_payment_date">Expected Payment Date</label>
              <input type="date" name="expected_payment_date" id="expected_payment_date" class="form-control">
          </div>

          <div class="form-group mb-3">
              <label for="notes">Notes</label>
              <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group mb-3">
              <label for="is_paid">Payment Status</label>
              <select name="is_paid" id="is_paid" class="form-control">
                  <option value="0">Pending</option>
                  <option value="1">Paid</option>
              </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Pledge</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
