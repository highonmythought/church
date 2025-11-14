@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="container">
    <h2>Add Expense</h2>
    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date') }}" required>
        </div>
        <button class="btn btn-success">Add Expense</button>
    </form>
</div>
@endsection
