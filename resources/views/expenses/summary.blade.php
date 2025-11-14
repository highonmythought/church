@extends('layouts.app')

@section('title', 'Expense Summary')

@section('content')

<div class="container">
    <h2>Expense Summary Dashboard</h2>

    <!-- Year Filter & Export Buttons -->
    <form method="GET" action="{{ route('expenses.summary') }}" class="mb-3 row g-2">
        <div class="col-auto">
            <select name="year" class="form-select">
                @for($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" @if($year == $y) selected @endif>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('expenses.export.excel', ['year'=>$year]) }}" class="btn btn-success">Export Excel</a>
            <a href="{{ route('expenses.export.pdf', ['year'=>$year]) }}" class="btn btn-danger">Export PDF</a>
        </div>
    </form>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">This Month</h5>
                    <p class="card-text">₦{{ number_format($totalThisMonth ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">This Year</h5>
                    <p class="card-text">₦{{ number_format($totalThisYear ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">All Time</h5>
                    <p class="card-text">₦{{ number_format($totalAllTime ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Table -->
    @if(!empty($expensesDetails) && $expensesDetails->count())
    <div class="table-responsive mb-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Amount (₦)</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expensesDetails as $expense)
                <tr>
                    <td>{{ optional($expense->expense_date)->format('Y-m-d') ?? 'N/A' }}</td>
                    <td>{{ $expense->title ?? 'N/A' }}</td>
                    <td>₦{{ number_format($expense->amount ?? 0, 2) }}</td>
                    <td>{{ $expense->description ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="text-center text-muted py-4">No expenses found for {{ $year }}.</div>
    @endif

    <!-- Expense Chart -->
    <canvas id="expenseChart" width="400" height="200"></canvas>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Total Expenses (₦)',
                data: @json($expenses ?? array_fill(0, 12, 0)),
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
