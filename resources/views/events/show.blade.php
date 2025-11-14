@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Event Details</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5><strong>Event Type:</strong> {{ $event->event_type }}</h5>
            <p><strong>Description:</strong> {{ $event->description ?? '—' }}</p>
            <p><strong>Date:</strong> {{ $event->date->format('Y-m-d') }}</p>
            <p><strong>Time:</strong> {{ $event->time ?? '—' }}</p>
        </div>
    </div>
{{-- Upload Multiple Photos --}}
<h5 class="mt-4">Upload Event Photos</h5>
<form id="multiPhotoUploadForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event->id }}">
    
    <div class="mb-3">
        <input type="file" name="photos[]" multiple class="form-control" accept="image/*" required>
    </div>

    {{-- Live Preview Container --}}
    <div id="photoPreview" class="row g-2 mb-3"></div>

    <button type="submit" class="btn btn-primary">Upload Photos</button>
</form>

{{-- Progress Bar --}}
<div class="progress mt-3" style="height: 20px; display: none;">
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
</div>

{{-- Gallery --}}
<h5 class="mb-3 mt-5">Event Gallery</h5>
<div id="photoGallery" class="row g-3">
    @forelse($event->photos ?? [] as $photo)
        <div class="col-md-3 col-sm-4 col-6 photo-card" id="photo-{{ $photo->id }}">
            <div class="card shadow-sm">
                <a href="{{ asset($photo->photo_path) }}" class="glightbox" data-gallery="event-gallery">
                    <img src="{{ asset($photo->photo_path) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                </a>
                <div class="card-body text-center">
                    <form class="delete-photo-form" data-photo-id="{{ $photo->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger delete-photo-btn">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">No photos uploaded yet.</p>
    @endforelse
</div>

    <a href="{{ route('events.index') }}" class="btn btn-secondary mt-4">Back</a>
</div>

{{-- Dependencies --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('multiPhotoUploadForm');
    const fileInput = form.querySelector('input[name="photos[]"]');
    const previewContainer = document.getElementById('photoPreview');
    const progressBarContainer = document.querySelector('.progress');
    const progressBar = document.querySelector('.progress-bar');
    const gallery = document.getElementById('photoGallery');

    // ✅ Preview selected images
    fileInput.addEventListener('change', () => {
        previewContainer.innerHTML = '';
        Array.from(fileInput.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.classList.add('col-md-3', 'col-sm-4', 'col-6');
                div.innerHTML = `
                    <div class="card shadow-sm">
                        <img src="${e.target.result}" class="card-img-top" style="height:150px;object-fit:cover;">
                    </div>`;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // ✅ Upload photos with progress
    form.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(form);

        progressBarContainer.style.display = 'block';
        progressBar.style.width = '0%';
        progressBar.innerText = '0%';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', "{{ route('event_photos.store', ['event' => $event->id]) }}", true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.addEventListener('progress', e => {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressBar.innerText = percent + '%';
            }
        });

        xhr.onload = () => {
            progressBar.classList.remove('progress-bar-animated');
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.success && data.photos) {
                    previewContainer.innerHTML = '';
                    data.photos.forEach(photo => {
                        const div = document.createElement('div');
                        div.classList.add('col-md-3', 'col-sm-4', 'col-6', 'photo-card');
                        div.id = `photo-${photo.id}`;
                        div.innerHTML = `
                            <div class="card shadow-sm">
                                <a href="${photo.photo_path}" class="glightbox" data-gallery="event-gallery">
                                    <img src="${photo.photo_path}" class="card-img-top" style="height:180px;object-fit:cover;">
                                </a>
                                <div class="card-body text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-photo-btn" data-id="${photo.id}">Delete</button>
                                </div>
                            </div>`;
                        gallery.prepend(div);
                    });

                    if (window.glightbox) window.glightbox.destroy();
                    window.glightbox = GLightbox({ selector: '.glightbox' });

                    showToast('Photos uploaded successfully!');
                } else {
                    showToast('Upload failed.', 'error');
                }
            } else {
                showToast('Server error.', 'error');
            }

            setTimeout(() => {
                progressBarContainer.style.display = 'none';
                progressBar.classList.add('progress-bar-animated');
            }, 1500);
        };

        xhr.onerror = () => showToast('Upload failed. Try again.', 'error');

        xhr.send(formData);
    });

    // ✅ Delete photos instantly
    document.addEventListener('click', e => {
        if (e.target.classList.contains('delete-photo-btn')) {
            const id = e.target.dataset.id;
            if (!confirm('Are you sure you want to delete this photo?')) return;

            fetch(`/event-photos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`photo-${id}`).remove();
                    showToast('Photo deleted successfully!');
                } else {
                    showToast('Delete failed.', 'error');
                }
            })
            .catch(() => showToast('Error deleting photo.', 'error'));
        }
    });

    // ✅ Toast helper
    function showToast(msg, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-message bg-${type === 'success' ? 'success' : 'danger'} text-white p-2 rounded position-fixed bottom-0 end-0 m-3`;
        toast.style.zIndex = 9999;
        toast.innerText = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ✅ Initialize Lightbox
    window.glightbox = GLightbox({ selector: '.glightbox' });
});
</script>
@endsection
