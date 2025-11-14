<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session Expired</title>
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
        }
        .error-code {
            font-size: 100px;
            font-weight: 900;
            color: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">419</div>
        <h2>Session Expired</h2>
        <p>Your session has expired. Please log in again.</p>
        <a href="{{ route('login') }}" class="btn btn-light mt-3">Login Again</a>
    </div>
</body>
</html>
