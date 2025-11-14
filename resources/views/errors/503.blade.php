<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Service Unavailable | Church App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .error-page { text-align: center; padding: 100px 15px; }
        .error-code { font-size: 120px; font-weight: bold; color: #6c757d; }
    </style>
</head>
<body>
    <div class="error-page container">
        <div class="error-code">503</div>
        <h1>Service Unavailable</h1>
        <p>Sorry, the service is temporarily unavailable. Please try again later.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Home</a>
    </div>
</body>
</html>
