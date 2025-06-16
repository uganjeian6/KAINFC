@extends('layouts.app')

@section('content')
<div class="form-section">
    <h2 class="form-section-title">Create Team</h2>

    <form action="{{ route('teams.store') }}" method="POST" class="create-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Team Name</label>
            <input type="text" name="name" id="name" class="form-input" required>
            <span class="form-helper-text">Enter a unique name for your team</span>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3" class="form-textarea"></textarea>
            <span class="form-helper-text">Provide a brief description of the team's purpose</span>
        </div>

        <div class="form-group">
            <label for="team_leader_id" class="form-label">Team Leader</label>
            <select name="team_leader_id" id="team_leader_id" class="form-select" required>
                <option value="">Select Team Leader</option>
                @foreach($leaders as $leader)
                <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                @endforeach
            </select>
            <span class="form-helper-text">Choose a team leader from the list</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Create Team
            </button>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
