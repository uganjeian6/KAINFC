@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h2 class="card-title">Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                Create Task
            </a>
        </div>
    </div>

    @if($tasks->isEmpty())
    <div class="text-center py-4 text-gray-500">
        No tasks found.
    </div>
    @else
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Team</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>
                        <a href="{{ route('tasks.show', $task) }}" class="card-link">
                            {{ $task->title }}
                        </a>
                    </td>
                    <td>{{ $task->team->name }}</td>
                    <td>{{ $task->assignedUser->name ?? 'Unassigned' }}</td>
                    <td>
                        <span class="status-badge status-{{ $task->status }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>
                    <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary btn-sm">View</a>
                            @if(Auth::user()->role === 'admin' || Auth::user()->id === $task->team->team_leader_id || Auth::user()->id === $task->assigned_to)
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
