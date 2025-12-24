@extends('layouts.auth')
@section('title', 'Create Account')
@section('content')

<div class="nk-block nk-block-middle nk-auth-body">
    <div class="brand-logo pb-5">
        <a href="#" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="{{ asset('assets/images/atpr_logo.png') }}" srcset="{{ asset('assets/images/atpr_logo.png') }}" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="{{ asset('assets/images/atpr_logo.png') }}" srcset="{{ asset('assets/images/atpr_logo.png') }}" alt="logo-dark">
        </a>
    </div>
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Create account</h5>
            <div class="nk-block-des">
                <p>Access the {{ config('app.name')}} panel using your email and passcode.</p>
            </div>
        </div>
    </div>
    <form action="{{ route('register') }}" class="form-validate is-alter" method="POST">
        @csrf
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email-address">Username</label>
            </div>
            <div class="form-control-wrap">
                <input type="text" name="name" class="form-control form-control-lg" required id="name" placeholder="Enter your name">
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email-address">Email</label>
                <a class="link link-primary link-sm" tabindex="-1" href="#">Need Help?</a>
            </div>
            <div class="form-control-wrap">
                <input type="text" name="email" class="form-control form-control-lg" required id="email" placeholder="Enter your email address">
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Passcode</label>
                <a class="link link-primary link-sm" tabindex="-1" href="/password/reset">Forgot Code?</a>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input name="password" type="password" class="form-control form-control-lg" required id="password" placeholder="Enter your passcode">
                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label">Confirm Password</label>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                @error('password_confirmation')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
        </div>
        
    </form>
    <div class="form-note-s2 pt-4">Already have an account? <a href="{{ route('login') }}" class="fw-bold">Login</a>
    </div>
</div>

@endsection