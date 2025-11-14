@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="container">
    <h2 class="mb-3">Expenses</h2>
    <a href="{{ route('expenses.create') }}" class="btn btn-success mb-3">Add Expense</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $expense->title }}</td>
                <td>{{ $expense->description }}</td>
                <td>{{ number_format($expense->amount, 2) }}</td>
                <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('expenses.show', $expense) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">No expenses found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $expenses->links() }}
</div>
@endsection
