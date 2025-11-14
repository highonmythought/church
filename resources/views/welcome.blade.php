<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome - Church Management</title>

```
<!-- Fonts and styles -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
<link href="css/sb-admin-2.min.css" rel="stylesheet">

<style>
    .hero {
background: url('images/church-hero.jpg') no-repeat center center;
background-size: cover;
position: relative;
color: white;
min-height: 60vh;
display: flex;
align-items: center;
}

.hero::before {
content: "";
position: absolute;
top: 0; left: 0;
width: 100%; height: 100%;
background: linear-gradient(
rgba(0, 123, 255, 0.5),
rgba(0, 123, 255, 0.5)
); /* matches login/register overlay */
}

.hero-content {
position: relative;
z-index: 2;
text-shadow: 0 2px 6px rgba(0,0,0,0.4); /* adds subtle text depth */
}


    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>
```

</head>

<body class="bg-gradient-primary">

```
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Church Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>

<!-- Hero Section -->
<!-- Hero Section -->
<section class="hero text-center mb-5">
    <div class="hero-content container">
        <h1 class="display-4 fw-bold">Welcome to Our Church!</h1>
        <p class="lead mb-4">Stay connected with church activities, events, and community updates.</p>
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success me-2">Register</a>
            <a href="{{ route('members.publicRegister') }}" class="btn btn-light text-dark border">
                <i class="fas fa-user-plus me-1"></i> Register as Member
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-light">Go to Dashboard</a>
        @endguest
    </div>
</section>


<!-- Call-to-Action Cards -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm card-hover text-center p-3">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Upcoming Events</h5>
                    <p class="card-text">View and register for all church events.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary">View Events</a>
                </div>
            </div>
        </div>
       
        <div class="col-md-4">
            <div class="card shadow-sm card-hover text-center p-3">
                <div class="card-body">
                    <i class="fas fa-users fa-3x mb-3 text-warning"></i>
                    <h5 class="card-title">Member Dashboard</h5>
                    <p class="card-text">Access your profile, giving history, and more.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-warning text-white">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
```

</body>

</html>
