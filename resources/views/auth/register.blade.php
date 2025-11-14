@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <h2 class="mb-4">Create Account</h2>

    @if ($errors->any())
        <div class="mb-4 text-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <p class="mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
@endsection
