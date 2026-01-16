<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password | {{ config('app.name') }}</title>
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
        <div class="col-lg-8">

            <div class="glass-wrapper row g-0">

                {{-- Left Panel --}}
                <div class="col-md-6 glass-left d-none d-md-flex flex-column justify-content-center">
                    <img src="{{ asset('assets/images/atpr_logo.png') }}" style="max-width: 120px" class="mb-4">

                    <h2 class="fw-bold">Reset Password</h2>
                    <p class="text-white-50 mt-2">
                        Secure access to {{ config('app.name') }} dashboard.
                    </p>

                    <div class="divider my-4"></div>

                    <small class="text-white-50">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </small>
                </div>

                {{-- Right Panel --}}
                <div class="col-md-6 glass-right">
                    <h4 class="fw-bold text-white mb-3">Sign In</h4>

                    @if ($errors->any())
                    <div class="alert alert-danger small">
                        Incorrect email or password.
                    </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg glass-input" required>
                            @error('email')
                            <small class="text-warning">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-white"> Remembered the password<a href="{{ route('login') }}" class="text-white-50 small">
                                Login?
                            </a></span>
                        </div>

                        <button type="submit" class="btn btn-glass w-100 py-3 rounded-pill" id="loginBtn">
                            <span class="btn-text">Send</span>
                            <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.querySelector('.btn-text').classList.add('d-none');
            document.getElementById('spinner').classList.remove('d-none');
        });
    </script>

</body>

</html>