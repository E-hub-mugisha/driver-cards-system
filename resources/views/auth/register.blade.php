<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }

        label {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <h2 class="text-center text-white fw-bold mb-4">Create Account</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-light w-100 fw-bold">Register</button>
            <p class="text-center text-white mt-3">Already have an account? <a href="{{ route('login') }}" class="text-white fw-bold">Login</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>