@extends('layouts.app')

@section('content')
<div class="form-section auth-form">
    <h2 class="form-section-title">Login</h2>

    <form method="POST" action="{{ route('login') }}" class="create-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-input" required>
            <span class="form-helper-text">Enter your email address</span>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-input" required>
            <span class="form-helper-text">Enter your password</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Login
            </button>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                Register
            </a>
        </div>
    </form>
</div>
@endsection
