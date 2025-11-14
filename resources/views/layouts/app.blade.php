<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Church Admin Dashboard</title>

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('partials.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- End Page Content -->
            </div>

            <!-- Footer -->
            @include('partials.footer')
            <!-- End of Footer -->
        </div>
    </div>

    <!-- SB Admin 2 Scripts -->
     <!-- Remove this -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById('dashboard-search');
    const results = document.getElementById('search-results');
    let timer;

    input.addEventListener('keyup', function() {
        const query = this.value.trim();
        clearTimeout(timer);

        if (query.length < 2) {
            results.style.display = 'none';
            return;
        }

        timer = setTimeout(() => {
            fetch(`{{ route('search') }}?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                results.innerHTML = '';
                let hasResults = false;

                for (const [model, items] of Object.entries(data)) {
                    if (items.length > 0) {
                        hasResults = true;
                        results.innerHTML += `<div class="list-group-item active fw-bold">${model}</div>`;
                        items.forEach(item => {
                            const title = item.title || 'Unnamed';
                            const desc = item.description || '';
                            const url = item.url || '#';
                            results.innerHTML += `
                                <a href="${url}" class="list-group-item list-group-item-action">
                                    <div><strong>${title}</strong></div>
                                    <small class="text-muted">${desc}</small>
                                </a>`;
                        });
                    }
                }

                if (!hasResults) {
                    results.innerHTML = `<div class="list-group-item text-muted">No results found</div>`;
                }

                results.style.display = 'block';
            })
            .catch(err => console.error(err));
        }, 300);
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!results.contains(e.target) && e.target !== input) {
            results.style.display = 'none';
        }
    });
});
</script>


</body>
</html>
