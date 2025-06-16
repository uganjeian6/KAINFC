@extends('layouts.app')

@section('content')
<div class="dashboard-grid">
    <!-- Teams Overview -->
    <div class="card">
        <h3 class="card-title">Teams Overview</h3>
        <div class="card-content">
            @foreach(Auth::user()->teams as $team)
            <div class="card-item">
                <a href="{{ route('teams.show', $team) }}" class="card-link">
                    {{ $team->name }}
                </a>
                <p class="card-text">{{ $team->members->count() }} members</p>
            </div>
            @endforeach
        </div>
        <a href="{{ route('teams.index') }}" class="card-link">
            View all teams →
        </a>
    </div>

    <!-- Tasks Overview -->
    <div class="card">
        <h3 class="card-title">My Tasks</h3>
        <div class="card-content">
            @foreach(Auth::user()->assignedTasks as $task)
            <div class="card-item">
                <a href="{{ route('tasks.show', $task) }}" class="card-link">
                    {{ $task->title }}
                </a>
                <p class="card-text">Status: {{ ucfirst($task->status) }}</p>
            </div>
            @endforeach
        </div>
        <a href="{{ route('tasks.index') }}" class="card-link">
            View all tasks →
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <h3 class="card-title">Quick Actions</h3>
        <div class="card-content">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-block">
                Create New Task
            </a>
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'team_leader')
            <a href="{{ route('teams.create') }}" class="btn btn-secondary btn-block">
                Create New Team
            </a>
            @endif
            <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-block">
                Generate Report
            </a>
        </div>
    </div>
</div>
@endsection
