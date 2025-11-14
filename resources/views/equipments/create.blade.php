@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Equipment</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Acquired Date</label>
                    <input type="date" name="acquired_date" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo_path" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save Equipment</button>
                <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
