<!-- Laravel Auth Login (Bootstrap 5) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background: rgba(255, 255, 255);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 530px;
            color: #4f46e5;
        }

        label {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <h2 class="text-center text-primary fw-bold mb-4">Login</h2>

        @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- If user is logged in - show dashboard button -->
        @auth
        <h3 class="text-primary">The user {{ Auth::user()->name }} is currently logged in click button below to proceed</h3>
        <div class="text-center mb-3">
            @if(auth()->user()->type == 'admin')
            <a href="{{ route('admin.home') }}" class="btn btn-success w-100 fw-bold">Go to Admin Dashboard</a>
            @elseif(auth()->user()->type == 'manager')
            <a href="{{ route('manager.home') }}" class="btn btn-success w-100 fw-bold">Manager Dashboard</a>
            @else
            <a href="{{ route('driver.index') }}" class="btn btn-success w-100 fw-bold">Driver Dashboard</a>
            @endif
        </div>
        @endauth

        <!-- Show form only when user is NOT logged in -->
        @guest
        <form action="{{ route('login') }}" method="POST" class="mt-3">
            @csrf

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

            <button class="btn btn-light w-100 fw-bold">Login</button>

            <p class="text-center text-white mt-3">
                Don’t have an account? <a href="{{ route('register') }}" class="text-white fw-bold">Register</a>
            </p>
        </form>
        @endguest

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>