<footer class="text-center py-3 mt-4 border-top bg-light">
    <small>&copy; {{ date('Y') }} Church Management System | Built with ❤️ using Laravel & Bootstrap</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const contentWrapper = document.getElementById('contentWrapper');

    toggleBtn?.addEventListener('click', () => {
        if (window.innerWidth < 992) {
            // For mobile - slide overlay style
            sidebar.classList.toggle('show');
        } else {
            // For desktop - slide collapse style
            sidebar.classList.toggle('collapsed');
            contentWrapper.classList.toggle('expanded');
        }
    });
</script>
</body>
</html>

