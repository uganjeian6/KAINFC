<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                KAIN FC
            </a>

            @auth
            <ul class="navbar-menu">
                <li><a href="{{ route('dashboard') }}" class="navbar-link">Dashboard</a></li>
                <li><a href="{{ route('teams.index') }}" class="navbar-link">Teams</a></li>
                <li><a href="{{ route('tasks.index') }}" class="navbar-link">Tasks</a></li>
                <li><a href="{{ route('reports.index') }}" class="navbar-link">Reports</a></li>
            </ul>

            <div class="navbar-menu">
                <span class="navbar-link">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="navbar-link" style="background: none; border: none; cursor: pointer;">Logout</button>
                </form>
            </div>
            @else
            <div class="navbar-menu">
                <a href="{{ route('login') }}" class="navbar-link">Login</a>
                <a href="{{ route('register') }}" class="navbar-link">Register</a>
            </div>
            @endauth
        </div>
    </nav>

    <main class="main-container">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
