@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Equipment</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('equipments.update', $equipment) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $equipment->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Acquired Date</label>
                    <input type="date" name="acquired_date" value="{{ old('acquired_date', $equipment->acquired_date) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo_path" class="form-control">
                     @if($equipment->photo_path)
                <p><strong>Photo:</strong></p>
                <img src="{{ asset($equipment->photo_path) }}" class="img-fluid rounded" style="max-width: 300px;">
            @endif
        </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
