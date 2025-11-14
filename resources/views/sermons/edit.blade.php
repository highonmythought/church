@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4 text-gray-800">Edit Sermon</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('sermons.update', $sermon) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Preacher Type</label>
                    <select id="preacherType" class="form-control" onchange="togglePreacherFields()">
                        <option value="pastor" {{ $sermon->pastor_id ? 'selected' : '' }}>Pastor</option>
                        <option value="guest" {{ $sermon->guest_preacher ? 'selected' : '' }}>Guest Preacher</option>
                    </select>
                </div>

                <div id="pastorField" class="mb-3 {{ $sermon->guest_preacher ? 'd-none' : '' }}">
                    <label class="form-label">Select Pastor</label>
                    <select name="pastor_id" class="form-control">
                        <option value="">-- Select Pastor --</option>
                        @foreach($pastors as $pastor)
                            <option value="{{ $pastor->id }}" {{ $sermon->pastor_id == $pastor->id ? 'selected' : '' }}>
                                {{ $pastor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="guestField" class="mb-3 {{ $sermon->guest_preacher ? '' : 'd-none' }}">
                    <label class="form-label">Guest Preacher Name</label>
                    <input type="text" name="guest_preacher" value="{{ $sermon->guest_preacher }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bible Text</label>
                    <input type="text" name="bible_text" class="form-control" value="{{ $sermon->bible_text }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Event (optional)</label>
                    <select name="event_id" class="form-control">
                        <option value="">-- None --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $sermon->event_id == $event->id ? 'selected' : '' }}>
                                {{ $event->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $sermon->date->format('Y-m-d') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Summary</label>
                    <textarea name="summary" rows="4" class="form-control">{{ $sermon->summary }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Sermon</button>
                <a href="{{ route('sermons.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
function togglePreacherFields() {
    const type = document.getElementById('preacherType').value;
    document.getElementById('pastorField').classList.toggle('d-none', type !== 'pastor');
    document.getElementById('guestField').classList.toggle('d-none', type !== 'guest');
}
</script>
@endsection
