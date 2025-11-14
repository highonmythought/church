@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Member</h4>
    <a href="{{ route('members.index') }}" class="btn btn-secondary btn-sm mb-3">← Back</a>

    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">First Name *</label>
                <input type="text" name="first_name" class="form-control" value="{{ $member->first_name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Last Name *</label>
                <input type="text" name="last_name" class="form-control" value="{{ $member->last_name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $member->email }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $member->phone }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $member->address }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select</option>
                    <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="{{ $member->dob }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">None</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $member->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary mt-4">Update Member</button>
    </form>
</div>
@endsection
