@extends('layouts.app')

@section('content')
<div class="form-section">
    <h2 class="form-section-title">Create Task</h2>

    <form action="{{ route('tasks.store') }}" method="POST" class="create-form">
        @csrf

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="title" class="form-label">Task Title</label>
                    <input type="text" name="title" id="title" class="form-input" required>
                    <span class="form-helper-text">Enter a clear and concise title</span>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3" class="form-textarea" required></textarea>
            <span class="form-helper-text">Provide detailed information about the task</span>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label for="team_id" class="form-label">Team</label>
                    <select name="team_id" id="team_id" class="form-select" required>
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select name="assigned_to" id="assigned_to" class="form-select">
                        <option value="">Unassigned</option>
                        @foreach($teams as $team)
                            <optgroup label="{{ $team->name }}">
                                @foreach($team->members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-input">
            <span class="form-helper-text">Set a deadline for task completion</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Create Task
            </button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
