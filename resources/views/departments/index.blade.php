@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Departments</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
            <i class="fas fa-plus-circle me-1"></i> Add Department
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ substr($department->description, 0,50 ?? '—')}}...</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm"
                                    data-toggle="modal" data-target="#viewDepartmentModal{{ $department->id }}">
                                    View
                                </button>

                                <button type="button" class="btn btn-warning btn-sm"
                                    data-toggle="modal" data-target="#editDepartmentModal{{ $department->id }}">
                                    Edit
                                </button>

                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- View Department Modal -->
                        <div class="modal fade" id="viewDepartmentModal{{ $department->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">View Department</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <p><strong>Name:</strong> {{ $department->name }}</p>
                                  <p><strong>Description:</strong> {{ $department->description ?? '—' }}</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Edit Department Modal -->
                        <div class="modal fade" id="editDepartmentModal{{ $department->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form action="{{ route('departments.update', $department->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                  <h5 class="modal-title">Edit Department</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>

                                <div class="modal-body">
                                  <div class="mb-3">
                                      <label for="name{{ $department->id }}" class="form-label">Department Name</label>
                                      <input type="text" name="name" id="name{{ $department->id }}" class="form-control"
                                          value="{{ $department->name }}" required>
                                  </div>

                                  <div class="mb-3">
                                      <label for="description{{ $department->id }}" class="form-label">Description</label>
                                      <textarea name="description" id="description{{ $department->id }}" class="form-control"
                                          placeholder="Enter description">{{ $department->description }}</textarea>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                         </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No departments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
              <label for="name" class="form-label">Department Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter department name" required>
          </div>

          <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" class="form-control" placeholder="Enter department description"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Department</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
 
@push('scripts')
<script>
$(document).ready(function () {
    // View modal
    $('.viewDepartmentBtn').on('click', function () {
        $('#viewDeptName').text($(this).data('name'));
        $('#viewDeptDescription').text($(this).data('description'));
    });

    // Edit modal
    $('.editDepartmentBtn').on('click', function () {
        let id = $(this).data('id');
        $('#editDeptName').val($(this).data('name'));
        $('#editDeptDescription').val($(this).data('description'));
        $('#editDepartmentForm').attr('action', '/departments/' + id);
    });
});
</script>
@endpush
