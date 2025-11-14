<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Church Management - Forgot Password</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <style>
        .bg-left {
            background: url('{{ asset("images/church-left.jpg") }}') no-repeat center center;
            background-size: cover;
            position: relative;
            border-radius: 0.35rem 0 0 0.35rem;
        }
        .bg-left::before {
            content: "";
            position: absolute;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,123,255,0.5);
            border-radius: 0.35rem 0 0 0.35rem;
        }
    </style>
</head>
<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-left"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h1 class="h4 text-gray-900">Forgot Your Password?</h1>
                                    <p class="text-gray-600">Enter your email to receive a reset link.</p>
                                </div>


                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" type="email" name="email" class="form-control" required autofocus>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Back to Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


   </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="js/sb-admin-2.min.js"></script>

</body>
</html>
