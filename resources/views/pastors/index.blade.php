@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Pastors</h3>
    <!-- Add Pastor Button -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#addPastorModal">
        <i class="fas fa-plus-circle"></i> Add Pastor
    </button>
</div>

@if($pastors->count())
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Rank</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pastors as $pastor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pastor->name }}</td>
                            <td>{{ $pastor->rank }}</td>
                            <td>{{ $pastor->email ?? '—' }}</td>
                            <td>{{ $pastor->phone ?? '—' }}</td>
                            <td>
                                <a href="{{ route('pastors.show', $pastor->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('pastors.edit', $pastor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('pastors.destroy', $pastor->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="alert alert-info">No pastors found.</div>
@endif

<!-- Add Pastor Modal -->
<div class="modal fade" id="addPastorModal" tabindex="-1" role="dialog" aria-labelledby="addPastorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('pastors.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addPastorModalLabel">Add New Pastor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group mb-3">
              <label for="name">Full Name</label>
              <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="rank">Rank</label>
              <input type="text" name="rank" id="rank" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control">
          </div>

          <div class="form-group mb-3">
              <label for="phone">Phone</label>
              <input type="text" name="phone" id="phone" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Pastor</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
