@extends('layouts.app')

@section('content')
<h3>Attendance Trend Chart</h3>

<div class="card p-3 shadow-sm">
    <canvas id="attendanceChart" height="100"></canvas>
</div>

<script>
    const ctx = document.getElementById('attendanceChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: @json($datasets)
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: true, position: 'top' },
                title: { display: true, text: 'Church Attendance Over Time' }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'People Present' } },
                x: { title: { display: true, text: 'Date' } }
            }
        }
    });
</script>
@endsection
