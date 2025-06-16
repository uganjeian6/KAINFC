@extends('layouts.app')

@section('content')
<div class="form-section auth-form">
    <h2 class="form-section-title">Register</h2>

    <form method="POST" action="{{ route('register') }}" class="create-form">
        @csrf

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-input" required>
                    <span class="form-helper-text">Enter your full name</span>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-input" required>
                    <span class="form-helper-text">Enter your email address</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-input" required>
                    <span class="form-helper-text">Create a strong password</span>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
                    <span class="form-helper-text">Confirm your password</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="team_leader">Team Leader</option>
                <option value="member">Member</option>
            </select>
            <span class="form-helper-text">Select your role in the system</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Register
            </button>
            <a href="{{ route('login') }}" class="btn btn-secondary">
                Login
            </a>
        </div>
    </form>
</div>
@endsection
