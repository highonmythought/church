<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (for mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Nigerian Time -->
    <div class="text-gray-800 font-weight-bold mx-3" id="nigerian-time"></div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

    <!-- Global Search -->
    <li class="nav-item me-3">
        <div class="position-relative" style="max-width: 300px;">
            <input type="text" id="dashboard-search" name="q" class="form-control" 
                placeholder="Search anything..." autocomplete="off" value="{{ request('q') }}">
            <div id="search-results" class="list-group position-absolute w-100 shadow-sm" 
                style="z-index: 1000; display: none; max-height: 300px; overflow-y: auto;"></div>
        </div>
    </li>

        <!-- Notifications Dropdown -->
      <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
        @if($unread > 0)
            <span class="badge badge-danger badge-counter" id="alert-count">{{ $unread }}</span>
        @endif
    </a>

    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
         aria-labelledby="alertsDropdown" style="width: 320px;">
        <h6 class="dropdown-header">Notifications</h6>

        <div id="alert-list">
        @forelse(auth()->user()->unreadNotifications as $notification)
            <a href="#" class="dropdown-item d-flex align-items-center mark-read-alert"
               data-id="{{ $notification->id }}">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-info text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                    <span class="font-weight-bold">{{ $notification->data['message'] ?? 'New Alert' }}</span>
                </div>
            </a>
        @empty
            <div class="text-center py-3 text-gray-500">No new notifications</div>
        @endforelse
        </div>

        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-center small text-gray-500" href="{{ route('notifications.index') }}">View All Notifications</a>
    </div>
</li>


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>
                <img class="img-profile rounded-circle" 
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random">
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<!-- Nigerian Time Script -->
<script>
    function updateTime() {
        const options = { timeZone: 'Africa/Lagos', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        document.getElementById('nigerian-time').textContent =
            '🇳🇬 ' + new Date().toLocaleTimeString('en-NG', options);
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark individual alert as read and remove from dropdown
    document.querySelectorAll('.mark-read-alert').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            let id = this.dataset.id;
            fetch(`/notifications/mark-as-read/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(res => res.json())
            .then(data => {
                if(data.success){
                    this.remove(); // remove from dropdown
                    let countEl = document.getElementById('alert-count');
                    if(countEl){
                        let newCount = parseInt(countEl.innerText) - 1;
                        if(newCount <= 0) {
                            countEl.remove();
                        } else {
                            countEl.innerText = newCount;
                        }
                    }
                }
            });
        });
    });
});
</script>

