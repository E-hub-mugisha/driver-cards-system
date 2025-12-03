<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-dark bg-opacity-50">
    <div class="auth-card">
        <h2 class="text-center text-white fw-bold mb-4">Create New Password</h2>
        <form action="{{ route('password.store') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">


            <div class="mb-3">
                <label class="form-label text-white">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-light w-100 fw-bold">Reset Password</button>
        </form>
    </div>
</body>

</html>