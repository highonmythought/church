@extends('layouts.app')

@section('title', 'View Expense')

@section('content')

<div class="container">
    <h2>Expense Details</h2>


<table class="table table-bordered">
    <tr>
        <th>Title</th>
        <td>{{ $expenses->title ?? '-' }}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>{{ $expenses->description ?? '-' }}</td>
    </tr>
    <tr>
        <th>Amount</th>
        <td>{{ number_format($expenses->amount ?? 0, 2) }}</td>
    </tr>
    <tr>
        <th>Date</th>
        <td>{{ optional($expenses->expense_date)->format('Y-m-d') ?? 'N/A' }}</td>
    </tr>
</table>

<a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>


</div>
@endsection
