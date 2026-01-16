<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            font-family: 'Inter', sans-serif;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .glass-wrapper {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, .25);
            box-shadow: 0 25px 60px rgba(0, 0, 0, .4);
            overflow: hidden;
        }

        .glass-left {
            background: linear-gradient(135deg, rgba(255, 255, 255, .15), rgba(255, 255, 255, .05));
            padding: 3rem;
            color: #fff;
        }

        .glass-right {
            padding: 3rem;
            background: rgba(255, 255, 255, .05);
        }

        .glass-input {
            background: rgba(255, 255, 255, .15);
            border: none;
            color: #fff;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, .7);
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, .25);
            box-shadow: none;
            color: #fff;
        }

        label {
            color: #fff;
            font-weight: 500;
        }

        .btn-glass {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border: none;
            color: #fff;
        }

        .btn-glass:hover {
            opacity: .9;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, .25);
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-lg-10">

            <div class="glass-wrapper row g-0">

                {{-- Left Panel --}}
                <div class="col-md-6 glass-left d-none d-md-flex flex-column justify-content-center">
                    <img src="{{ asset('assets/images/atpr_logo.png') }}" style="max-width: 120px" class="mb-4">

                    <h2 class="fw-bold">Welcome!</h2>
                    <p class="text-white-50 mt-2">
                        Create an account to access {{ config('app.name') }} dashboard securely.
                    </p>

                    <div class="divider my-4"></div>

                    <small class="text-white-50">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </small>
                </div>

                {{-- Right Panel --}}
                <div class="col-md-6 glass-right">
                    <h4 class="fw-bold text-white mb-3">Sign Up</h4>

                    @if ($errors->any())
                    <div class="alert alert-danger small">
                        Please fix the errors below.
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control form-control-lg glass-input"
                                placeholder="Enter your full name"
                                required>
                            @error('name')
                            <small class="text-warning">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control form-control-lg glass-input"
                                placeholder="Enter your email"
                                required>
                            @error('email')
                            <small class="text-warning">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password"
                                    name="password"
                                    id="password"
                                    class="form-control form-control-lg glass-input"
                                    placeholder="Create a password"
                                    required>
                                <button class="btn btn-light" type="button" onclick="togglePassword()">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <small class="text-warning">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control form-control-lg glass-input"
                                placeholder="Re-enter your password"
                                required>
                            @error('password_confirmation')
                            <small class="text-warning">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-note-s2 mb-3">
                            <small class="text-white-50">
                                By creating an account, you agree to our
                                <a href="#" class="text-white fw-bold">Terms & Conditions</a>.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-glass w-100 py-3 rounded-pill" id="registerBtn">
                            <span class="btn-text">Create Account</span>
                            <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                        </button>
                    </form>

                    <div class="form-note-s2 text-center pt-4">
                        Already have an account?
                        <a href="{{ route('login') }}" class="fw-bold text-white">Sign In</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            btn.disabled = true;
            btn.querySelector('.btn-text').classList.add('d-none');
            document.getElementById('spinner').classList.remove('d-none');
        });
    </script>

</body>

</html>