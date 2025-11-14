<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Error')</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset("images/church-left.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            backdrop-filter: brightness(0.5);
        }
        .error-container {
            background: rgba(0,0,0,0.6);
            padding: 3rem;
            border-radius: 0.5rem;
            max-width: 600px;
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
            color: #f8f9fa;
            margin-top: 0.5rem;
        }
        .error-code {
            font-size: 100px;
            font-weight: 900;
            color: #f8d7da;
        }
        h1, h2 {
            font-weight: 700;
        }
        p {
            font-size: 1.1rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo">
            <img src="{{ asset('images/church-logo.png') }}" alt="Church Logo">
            <div class="app-name">Church Management System</div>
        </div>
        @yield('content')
    </div>
</body>
</html>
