@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Expense</h4>
            <a href="{{ route('expenses.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body bg-light">
<form action="{{ route('expenses.update', ['id' => $expense->id]) }}" method="POST" class="p-3">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            class="form-control shadow-sm" 
                            value="{{ old('title', $expense->title) }}" 
                            required>
                    </div>

                    <!-- Description -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea 
                            name="description" 
                            class="form-control shadow-sm" 
                            rows="1">{{ old('description', $expense->description) }}</textarea>
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Amount</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            name="amount" 
                            class="form-control shadow-sm" 
                            value="{{ old('amount', $expense->amount) }}" 
                            required>
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date</label>
                        <input 
                            type="date" 
                            name="expense_date" 
                            class="form-control shadow-sm" 
                            value="{{ old('expense_date', optional($expense->expense_date)->format('Y-m-d')) }}" 
                            required>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-2"></i> Update Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
