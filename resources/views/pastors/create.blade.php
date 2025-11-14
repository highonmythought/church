@extends('layouts.app')

@section('content')
<h3>Add Pastor</h3>
<form action="{{ route('pastors.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Rank</label>
        <input type="text" name="rank" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email (optional)</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Phone (optional)</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('pastors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
