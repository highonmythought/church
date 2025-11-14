@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h2 class="mb-4">Welcome Back!</h2>

    @if (session('status'))
        <div class="mb-4 text-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input">
            <label class="form-check-label">Remember Me</label>
        </div>
        <button type="submit" class="btn btn-success w-100">Login</button>
    </form>

    <p class="mt-3">
        Don’t have an account? <a href="{{ route('register') }}">Register here</a>.<br>
        @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        @endif
    </p>
@endsection
