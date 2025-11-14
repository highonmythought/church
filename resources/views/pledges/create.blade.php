@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Pledge</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pledges.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name (optional)</label>
                    <input type="text" name="name" class="form-control" placeholder="Anonymous">
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" step="0.01" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Expected Payment Date</label>
                    <input type="date" name="expected_payment_date" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Additional details"></textarea>
                </div>

            <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_paid" id="is_paid" value="1"
        {{ isset($pledge) && $pledge->is_paid ? 'checked' : '' }}>
    <label class="form-check-label" for="is_paid">Mark as Paid</label>
</div>

<div class="mb-3">
    <label class="form-label">Amount Paid</label>
    <input type="number" name="amount_paid" step="0.01" class="form-control"
           value="{{ $pledge->amount_paid ?? '' }}">
</div>

<div class="mb-3">
    <label class="form-label">Payment Date</label>
    <input type="date" name="payment_date" class="form-control"
           value="{{ $pledge->payment_date ?? '' }}">
</div>


                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('pledges.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
