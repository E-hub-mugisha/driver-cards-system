<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue: #00ADEE; --blue-dark: #0090c8; --amber: #E3B228;
            --text: #1a2235; --text-muted: #6b7a99; --border: #e4e9f2;
            --white: #ffffff; --surface: #f7f9fc;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        body::before {
            content: ''; position: fixed; top: -120px; right: -120px;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,173,238,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: ''; position: fixed; bottom: -100px; left: -100px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(227,178,40,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-container { width: 100%; max-width: 860px; padding: 1.5rem; z-index: 1; }
        .auth-card {
            background: var(--white); border-radius: 24px;
            box-shadow: 0 8px 40px rgba(26,34,53,0.10); display: flex; overflow: hidden; min-height: 520px;
        }
        .brand-panel {
            width: 42%; background: linear-gradient(145deg, #00ADEE 0%, #0072b8 100%);
            padding: 3rem 2.5rem; display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .brand-panel::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 240px; height: 240px; border-radius: 50%; background: rgba(255,255,255,0.08);
        }
        .brand-panel::after {
            content: ''; position: absolute; bottom: -40px; left: -40px;
            width: 180px; height: 180px; border-radius: 50%; background: rgba(227,178,40,0.15);
        }
        .brand-logo { max-width: 100px; display: block; }
        .brand-icon-wrap {
            width: 64px; height: 64px; border-radius: 18px;
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.75rem; color: var(--amber); margin-bottom: 1.5rem;
        }
        .brand-title { font-size: 1.9rem; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 0.75rem; }
        .brand-sub { font-size: 0.9rem; color: rgba(255,255,255,0.72); line-height: 1.6; }
        .brand-divider { height: 1px; background: rgba(255,255,255,0.2); margin: 1.5rem 0; }
        .brand-footer { font-size: 0.78rem; color: rgba(255,255,255,0.5); }
        .form-panel { flex: 1; padding: 3.5rem 3rem; display: flex; flex-direction: column; justify-content: center; }
        .form-eyebrow {
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--blue); margin-bottom: 0.5rem;
        }
        .form-title { font-size: 1.65rem; font-weight: 800; color: var(--text); margin-bottom: 0.5rem; }
        .form-desc { font-size: 0.88rem; color: var(--text-muted); margin-bottom: 2rem; line-height: 1.6; }
        .form-label { font-size: 0.83rem; font-weight: 600; color: var(--text); margin-bottom: 0.4rem; display: block; }
        .form-control {
            background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px;
            color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.92rem;
            padding: 0.7rem 1rem; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            background: var(--white); border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0,173,238,0.12); color: var(--text); outline: none;
        }
        .form-control::placeholder { color: #b0b9cc; }
        .btn-primary-main {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            border: none; border-radius: 12px; color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem; font-weight: 700;
            padding: 0.8rem 1.5rem; width: 100%; cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            box-shadow: 0 4px 18px rgba(0,173,238,0.25);
        }
        .btn-primary-main:hover { opacity: 0.92; transform: translateY(-1px); }
        .back-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            font-size: 0.85rem; color: var(--text-muted); text-decoration: none;
            font-weight: 600; margin-top: 1.25rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--blue); }
        .alert-success-msg {
            background: #edfaf3; border: 1.5px solid #a3e6c3; border-radius: 10px;
            color: #1a7a4a; font-size: 0.85rem; padding: 0.75rem 1rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .alert-error {
            background: #fff5f5; border: 1.5px solid #ffc9c9; border-radius: 10px;
            color: #c0392b; font-size: 0.83rem; padding: 0.65rem 1rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .text-warning-field { font-size: 0.78rem; color: #c0392b; margin-top: 0.3rem; display: block; }
        @media (max-width: 767px) {
            .brand-panel { display: none; }
            .form-panel { padding: 2.5rem 1.75rem; }
        }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="auth-card">

        {{-- Brand Panel --}}
        <div class="brand-panel d-none d-md-flex flex-column">
            <div>
                <img src="{{ asset('assets/images/atpr_logo.png') }}" class="brand-logo mb-4" alt="Logo">
                <div class="brand-icon-wrap"><i class="bi bi-envelope-paper-fill"></i></div>
                <h2 class="brand-title">Password Recovery</h2>
                <p class="brand-sub">Enter your registered email and we'll send you a secure link to reset your password.</p>
            </div>
            <div>
                <div class="brand-divider"></div>
                <p class="brand-footer">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="form-panel">
            <p class="form-eyebrow">Account Recovery</p>
            <h1 class="form-title">Forgot Password?</h1>
            <p class="form-desc">No worries — just enter your email address and we'll send you a reset link within a few minutes.</p>

            @if (session('status'))
            <div class="alert-success-msg"><i class="bi bi-check-circle-fill"></i> {{ session('status') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i> Please check your email address.</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" id="forgotForm">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                        placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                    @error('email')<span class="text-warning-field">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn-primary-main" id="sendBtn">
                    <i class="bi bi-send-fill"></i>
                    <span class="btn-text">Send Reset Link</span>
                    <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Back to Sign In
            </a>
        </div>

    </div>
</div>
<script>
document.getElementById('forgotForm').addEventListener('submit', function() {
    const btn = document.getElementById('sendBtn');
    btn.disabled = true;
    btn.querySelector('.btn-text').classList.add('d-none');
    document.getElementById('spinner').classList.remove('d-none');
});
</script>
</body>
</html>