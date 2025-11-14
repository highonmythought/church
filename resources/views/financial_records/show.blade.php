@extends('layouts.app')

@section('title', 'View Expense')

@section('content')

<div class="container">
    <h2>Financial Record Details</h2>


<table class="table table-bordered">
    <tr>
        <th>Event</th>
        <td>{{ $financialRecord->event->event_type ?? '-' }}</td>
    </tr>
    <tr>
        <th>Type</th>
        <td>{{  $financialRecord->type ?? '-' }}</td>
    </tr>
    <tr>
        <th>Amount</th>
        <td>{{ number_format($financialRecord->amount, 2) }}</td>
    </tr>
    <tr>
        <th>Date</th>
        <td>{{ $financialRecord->date->format('Y-m-d')  ?? 'N/A' }}</td>
    </tr>
</table>

<a href="{{ route('financial-records.index') }}" class="btn btn-secondary">Back</a>


</div>
@endsection
