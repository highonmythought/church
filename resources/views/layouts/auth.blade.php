<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Church Management System')</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset("images/church-left.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }
        .container-card {
            background: rgba(255,255,255,0.95);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            max-width: 500px;
            width: 100%;
        }
        .logo {
            margin-bottom: 1.5rem;
        }
        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        .app-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 0.5rem;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container-card">
        <div class="logo">
            <img src="{{ asset('images/church-logo.png') }}" alt="Church Logo">
            <div class="app-name">Church Management System</div>
        </div>
        @yield('content')
    </div>
</body>
</html>
