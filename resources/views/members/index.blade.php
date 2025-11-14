@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Members</h4>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addMemberModal">
            <i class="fas fa-plus-circle"></i> Add Member
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Members</h4>
    <input type="text" id="members-search" class="form-control w-25" placeholder="Search Members...">
</div>

<table class="table table-striped" id="members-table">

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                            <td>{{ $member->email ?? '—' }}</td>
                            <td>{{ $member->phone ?? '—' }}</td>
                            <td>{{ $member->department->name ?? '—' }}</td>
                            <td>{{ $member->gender ?? '—' }}</td>
                            <td>{{ $member->dob ? $member->dob->format('Y-m-d') : '—' }}</td>
                            <td>
                                <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-info">View</a>
                                @can('edit members')
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endcan
                                @can('delete members')
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this member?')">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById('members-search');
    const tableBody = document.querySelector('#members-table tbody');
    let timer;

    input.addEventListener('keyup', function() {
        const query = this.value.trim();
        clearTimeout(timer);

        timer = setTimeout(() => {
            fetch(`/members/search?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center">No results found</td></tr>';
                    return;
                }

                data.forEach(member => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${member.first_name} ${member.last_name ?? ''}</td>
                            <td>${member.email}</td>
                            <td>${member.phone ?? '-'}</td>
                            <td>
                                <a href="/members/${member.id}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(err => console.error(err));
        }, 300);
    });
});
</script>


<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group mb-3">
              <label for="first_name">First Name</label>
              <input type="text" name="first_name" id="first_name" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="last_name">Last Name</label>
              <input type="text" name="last_name" id="last_name" class="form-control" required>
          </div>

          <div class="form-group mb-3">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control">
          </div>

          <div class="form-group mb-3">
              <label for="phone">Phone</label>
              <input type="text" name="phone" id="phone" class="form-control">
          </div>

          <div class="form-group mb-3">
              <label for="department_id">Department</label>
              <select name="department_id" id="department_id" class="form-control">
                  <option value="">Select Department</option>
                  @foreach($departments as $department)
                      <option value="{{ $department->id }}">{{ $department->name }}</option>
                  @endforeach
              </select>
          </div>

          <div class="form-group mb-3">
              <label for="gender">Gender</label>
              <select name="gender" id="gender" class="form-control">
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
              </select>
          </div>

          <div class="form-group mb-3">
              <label for="dob">Date of Birth</label>
              <input type="date" name="dob" id="dob" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Member</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
