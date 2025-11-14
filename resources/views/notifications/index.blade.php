@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Notifications</h2>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form id="markAllForm" action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary">
                    Mark All as Read
                </button>
            </form>
        @endif
    </div>

    <div id="alert-area"></div>

    <div class="list-group shadow-sm" id="notifications-list">
        @forelse ($notifications as $notification)
            <div id="notif-{{ $notification->id }}" 
                 class="list-group-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'list-group-item-info' }}">
                <div>
                    <strong>{{ $notification->data['message'] ?? 'Notification' }}</strong>
                    <div class="text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                </div>

                @if(!$notification->read_at)
                    <button class="btn btn-sm btn-outline-success mark-read-btn" data-id="{{ $notification->id }}">
                        Mark as Read
                    </button>
                @endif
            </div>
        @empty
            <div class="text-center py-4 text-gray-500">
                No notifications found.
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // Handle single mark-as-read
    $('.mark-read-btn').on('click', function() {
        let id = $(this).data('id');
        let $notif = $('#notif-' + id);

        $.ajax({
            url: '/notifications/' + id + '/mark-read',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                $notif.fadeOut(300, function() {
                    $(this).remove();
                    showAlert('Notification marked as read.', 'success');
                });
            },
            error: function() {
                showAlert('Error marking notification as read.', 'danger');
            }
        });
    });

    // Handle Mark All as Read
    $('#markAllForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                $('#notifications-list').fadeOut(300, function() {
                    $(this).html('<div class="text-center py-4 text-gray-500">All notifications marked as read.</div>').fadeIn();
                });
                showAlert('All notifications marked as read.', 'success');
            },
            error: function() {
                showAlert('Error marking all notifications.', 'danger');
            }
        });
    });

    // Display feedback messages
    function showAlert(message, type) {
        $('#alert-area').html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
    }
});
</script>
@endsection
