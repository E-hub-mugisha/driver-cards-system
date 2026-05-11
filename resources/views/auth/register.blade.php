<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue: #00ADEE;
            --blue-dark: #0090c8;
            --amber: #E3B228;
            --text: #1a2235;
            --text-muted: #6b7a99;
            --border: #e4e9f2;
            --white: #ffffff;
            --surface: #f7f9fc;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
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
        .auth-container { width: 100%; max-width: 1000px; padding: 1.5rem; z-index: 1; }
        .auth-card {
            background: var(--white); border-radius: 24px;
            box-shadow: 0 8px 40px rgba(26,34,53,0.10), 0 1.5px 6px rgba(0,173,238,0.06);
            display: flex; overflow: hidden; min-height: 600px;
        }
        .brand-panel {
            width: 42%;
            background: linear-gradient(145deg, #00ADEE 0%, #0072b8 100%);
            padding: 3rem 2.5rem;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .brand-panel::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 240px; height: 240px; border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .brand-panel::after {
            content: ''; position: absolute; bottom: -40px; left: -40px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(227,178,40,0.15);
        }
        .brand-logo { max-width: 100px; display: block; }
        .brand-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
            border-radius: 100px; padding: 0.35rem 0.85rem;
            font-size: 0.75rem; color: #fff; font-weight: 600; letter-spacing: 0.04em;
            width: fit-content; margin-bottom: 1.5rem;
        }
        .brand-badge i { color: var(--amber); }
        .brand-title { font-size: 2rem; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 0.75rem; }
        .brand-sub { font-size: 0.9rem; color: rgba(255,255,255,0.72); line-height: 1.6; }
        .brand-divider { height: 1px; background: rgba(255,255,255,0.2); margin: 1.5rem 0; }
        .brand-footer { font-size: 0.78rem; color: rgba(255,255,255,0.5); }
        .brand-steps { display: flex; flex-direction: column; gap: 1rem; margin-top: 1.75rem; }
        .brand-step { display: flex; align-items: flex-start; gap: 0.75rem; }
        .step-num {
            width: 26px; height: 26px; border-radius: 8px;
            background: rgba(227,178,40,0.25); border: 1px solid rgba(227,178,40,0.4);
            color: var(--amber); font-size: 0.75rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .step-text { font-size: 0.82rem; color: rgba(255,255,255,0.82); line-height: 1.5; padding-top: 2px; }
        .form-panel { flex: 1; padding: 2.5rem 2.75rem; display: flex; flex-direction: column; justify-content: center; }
        .form-eyebrow {
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--blue); margin-bottom: 0.5rem;
        }
        .form-title { font-size: 1.65rem; font-weight: 800; color: var(--text); margin-bottom: 0.35rem; }
        .form-sub { font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1.75rem; }
        .form-sub a { color: var(--blue); font-weight: 600; text-decoration: none; }
        .form-sub a:hover { text-decoration: underline; }
        .form-label { font-size: 0.83rem; font-weight: 600; color: var(--text); margin-bottom: 0.4rem; display: block; }
        .form-control {
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 12px; color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.92rem;
            padding: 0.7rem 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            background: var(--white); border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0,173,238,0.12); color: var(--text); outline: none;
        }
        .form-control::placeholder { color: #b0b9cc; }
        .input-group .form-control { border-right: none; border-radius: 12px 0 0 12px; }
        .input-group .btn-eye {
            background: var(--surface); border: 1.5px solid var(--border); border-left: none;
            border-radius: 0 12px 12px 0; color: var(--text-muted); padding: 0 1rem; transition: color 0.2s;
        }
        .input-group .btn-eye:hover { color: var(--blue); }
        .btn-primary-main {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            border: none; border-radius: 12px; color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem; font-weight: 700;
            padding: 0.8rem 1.5rem; width: 100%; cursor: pointer;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            box-shadow: 0 4px 18px rgba(0,173,238,0.25);
        }
        .btn-primary-main:hover { opacity: 0.92; transform: translateY(-1px); box-shadow: 0 6px 24px rgba(0,173,238,0.32); }
        .btn-primary-main:disabled { opacity: 0.7; transform: none; }
        .terms-note { font-size: 0.78rem; color: var(--text-muted); margin-bottom: 1.25rem; }
        .terms-note a { color: var(--amber); font-weight: 600; text-decoration: none; }
        .terms-note a:hover { text-decoration: underline; }
        .alert-error {
            background: #fff5f5; border: 1.5px solid #ffc9c9; border-radius: 10px;
            color: #c0392b; font-size: 0.83rem; padding: 0.65rem 1rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .text-warning-field { font-size: 0.78rem; color: #c0392b; margin-top: 0.3rem; display: block; }
        .row-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1rem; }
        @media (max-width: 767px) {
            .brand-panel { display: none; }
            .form-panel { padding: 2.5rem 1.75rem; }
            .row-fields { grid-template-columns: 1fr; }
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
                <div class="brand-badge"><i class="bi bi-stars"></i> New Account</div>
                <h2 class="brand-title">Get Started Today</h2>
                <p class="brand-sub">Join {{ config('app.name') }} and manage transport operations efficiently.</p>
                <div class="brand-steps">
                    <div class="brand-step"><span class="step-num">1</span><p class="step-text">Fill in your personal details below</p></div>
                    <div class="brand-step"><span class="step-num">2</span><p class="step-text">Verify your email address</p></div>
                    <div class="brand-step"><span class="step-num">3</span><p class="step-text">Access the full dashboard</p></div>
                </div>
            </div>
            <div>
                <div class="brand-divider"></div>
                <p class="brand-footer">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="form-panel">
            <p class="form-eyebrow">Dashboard Portal</p>
            <h1 class="form-title">Create Account</h1>
            <p class="form-sub">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>

            @if ($errors->any())
            <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i> Please fix the errors below.</div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control" placeholder="Enter your full name" required>
                    @error('name')<span class="text-warning-field">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control" placeholder="you@example.com" required>
                    @error('email')<span class="text-warning-field">{{ $message }}</span>@enderror
                </div>

                <div class="row-fields">
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control" placeholder="Create password" required>
                            <button class="btn-eye" type="button" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')<span class="text-warning-field">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Repeat password" required>
                            <button class="btn-eye" type="button" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <p class="terms-note">
                    By creating an account, you agree to our <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.
                </p>

                <button type="submit" class="btn-primary-main" id="registerBtn">
                    <span class="btn-text">Create Account</span>
                    <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                </button>
            </form>
        </div>

    </div>
</div>
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
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