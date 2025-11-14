@extends('errors.layout')

@section('title', 'An Error Occurred')

@section('content') <div class="error-code">{{ $exception->getStatusCode() ?? 'Error' }}</div> <h1>Something Went Wrong</h1> <p>We encountered an unexpected issue. Please try again later or contact the administrator.</p> <p><a href="{{ url('/') }}" class="btn btn-light mt-3">Return Home</a></p>
@endsection
