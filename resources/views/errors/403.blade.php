<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
        }
        .error-container img {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
        .error-container h1 {
            font-size: 3rem;
            color: #333;
            margin: 0;
        }
        .error-container p {
            font-size: 1.2rem;
            color: #666;
        }
        .error-container a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
        }
        .error-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <img src="{{asset('icon/peringatan.png')}}" alt="Page Not Found">
        <h1>Oops! Error 403</h1>
        <p>Sorry, anda tidak memiliki akses ke halaman ini. Silahkan menghubungi admin untuk tindakan lebih lanjut.</p>
        <a href="{{ route('home') }}">Go Back to Homepage</a>
    </div>
</body>
</html>
