@extends('layouts.app')

@section('content')
<h3>Edit Pastor</h3>
<form action="{{ route('pastors.update', $pastor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $pastor->name }}" required>
    </div>

    <div class="mb-3">
        <label>Rank</label>
        <input type="text" name="rank" class="form-control" value="{{ $pastor->rank }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $pastor->email }}">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $pastor->phone }}">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('pastors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
