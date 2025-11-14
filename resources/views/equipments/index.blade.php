@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Equipments</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addEquipmentModal">
            <i class="fas fa-plus-circle"></i> Add Equipment
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($equipments->isEmpty())
                <p class="text-center text-muted">No equipments added yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Acquired Date</th>
                                <th>Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipments as $equipment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $equipment->name }}</td>
                                    <td>{{ $equipment->description ?? '—' }}</td>
                                    <td>{{ $equipment->acquired_date ?? '—' }}</td>
                                    <td>
                                        @if($equipment->photo_path)
                                            <img src="{{ asset($equipment->photo_path) }}" alt="Equipment Photo" width="60" class="rounded">
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('equipments.show', $equipment) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('equipments.edit', $equipment) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('equipments.destroy', $equipment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this equipment?')">Delete</button>
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

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group mb-3">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="description">Description</label>
              <textarea name="description" id="description" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group mb-3">
              <label for="acquired_date">Acquired Date</label>
              <input type="date" name="acquired_date" id="acquired_date" class="form-control">
          </div>

          <div class="form-group mb-3">
              <label for="photo">Photo (optional)</label>
              <input type="file" name="photo_path" id="photo_path" class="form-control-file" accept="image/*">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Equipment</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
