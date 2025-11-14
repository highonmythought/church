@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-gray-800">Sermon Details</h1>
        <a href="{{ route('sermons.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="text-primary mb-3">
                <i class="bi bi-journal-text me-2"></i> Sermon Information
            </h5>

            <table class="table table-borderless">
                <tr>
                    <th>Date:</th>
                    <td>{{ $sermon->date->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <th>Preacher:</th>
                    <td>
                        {{ $sermon->pastor ? $sermon->pastor->name : $sermon->guest_preacher }}
                    </td>
                </tr>
                <tr>
                    <th>Bible Text:</th>
                    <td>{{ $sermon->bible_text ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Event:</th>
                    <td>{{ $sermon->event->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Summary:</th>
                    <td>{{ $sermon->summary ?? '—' }}</td>
                </tr>
            </table>

            <div class="mt-4">
                <a href="{{ route('sermons.edit', $sermon) }}" class="btn btn-warning me-2">Edit</a>
                <form action="{{ route('sermons.destroy', $sermon) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sermon?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
