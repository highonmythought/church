@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4 text-gray-800">Add Sermon</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('sermons.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Preacher Type</label>
                    <select id="preacherType" class="form-control" onchange="togglePreacherFields()">
                        <option value="pastor">Pastor</option>
                        <option value="guest">Guest Preacher</option>
                    </select>
                </div>
                
                 <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>

                <div id="pastorField" class="mb-3">
                    <label class="form-label">Select Pastor</label>
                    <select name="pastor_id" class="form-control">
                        <option value="">-- Select Pastor --</option>
                        @foreach($pastors as $pastor)
                            <option value="{{ $pastor->id }}">{{ $pastor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="guestField" class="mb-3 d-none">
                    <label class="form-label">Guest Preacher Name</label>
                    <input type="text" name="guest_preacher" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bible Text</label>
                    <input type="text" name="bible_text" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Event (optional)</label>
                    <select name="event_id" class="form-control">
                        <option value="">-- None --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Summary</label>
                    <textarea name="summary" rows="4" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Sermon</button>
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
