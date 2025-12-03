<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-dark bg-opacity-50">
    <div class="auth-card">
        <h2 class="text-center text-white fw-bold mb-4">Verify Your Email</h2>


        <p class="text-white mb-3 text-center">A verification link has been sent to your email.</p>


        <form action="{{ route('verification.send') }}" method="POST" class="text-center">
            @csrf
            <button class="btn btn-light fw-bold w-100">Resend Verification Email</button>
        </form>


        <form action="{{ route('logout') }}" method="POST" class="text-center mt-3">
            @csrf
            <button class="btn btn-outline-light w-100">Logout</button>
        </form>
    </div>
</body>

</html>