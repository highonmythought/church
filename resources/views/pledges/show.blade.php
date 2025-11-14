@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Pledge Details</h3>
        <a href="{{ route('pledges.index') }}" class="btn btn-secondary btn-sm">← Back to List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $pledge->name ?? 'Anonymous' }}</h5>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Amount Pledged:</strong>
                    ₦{{ number_format($pledge->amount, 2) }}
                </div>
                <div class="col-md-6">
                    <strong>Expected Payment Date:</strong>
                    {{ $pledge->expected_payment_date ? $pledge->expected_payment_date->format('M d, Y') : 'Not set' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Status:</strong>
                    @if($pledge->is_paid)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Payment Date:</strong>
                    {{ $pledge->payment_date ? $pledge->payment_date->format('M d, Y') : 'N/A' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Amount Paid:</strong>
                    ₦{{ number_format($pledge->amount_paid ?? 0, 2) }}
                </div>
                <div class="col-md-6">
                    <strong>Outstanding:</strong>
                    ₦{{ number_format(($pledge->amount - ($pledge->amount_paid ?? 0)), 2) }}
                </div>
            </div>

            @if($pledge->notes)
                <div class="mt-3">
                    <strong>Notes:</strong>
                    <p class="text-muted">{{ $pledge->notes }}</p>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('pledges.edit', $pledge->id) }}" class="btn btn-primary btn-sm">Edit</a>

                <form action="{{ route('pledges.destroy', $pledge->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this pledge?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
