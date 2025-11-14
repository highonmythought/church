@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ $equipment->name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Description:</strong> {{ $equipment->description ?? '—' }}</p>
            <p><strong>Acquired Date:</strong> {{ $equipment->acquired_date ?? '—' }}</p>
            @if($equipment->photo_path)
                <p><strong>Photo:</strong></p>
                <img src="{{ asset($equipment->photo_path) }}" class="img-fluid rounded" style="max-width: 300px;">
            @endif
        </div>
    </div>
    <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
