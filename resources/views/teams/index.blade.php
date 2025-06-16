@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h2 class="card-title">Teams</h2>
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'team_leader')
            <a href="{{ route('teams.create') }}" class="btn btn-primary">
                Create Team
            </a>
            @endif
        </div>
    </div>

    @if($teams->isEmpty())
    <div class="text-center py-4 text-gray-500">
        No teams found.
    </div>
    @else
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Team Leader</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>
                        <a href="{{ route('teams.show', $team) }}" class="card-link">
                            {{ $team->name }}
                        </a>
                    </td>
                    <td>
                        <div class="team-leader">
                            <span class="team-leader-name">{{ $team->leader->name }}</span>
                            <span class="team-leader-badge">Leader</span>
                        </div>
                    </td>
                    <td>
                        <div class="team-members">
                            <span class="member-count">{{ $team->members->count() }}</span>
                            <span class="member-label">members</span>
                        </div>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('teams.show', $team) }}" class="btn btn-secondary btn-sm">View</a>
                            @if(Auth::user()->role === 'admin' || Auth::user()->id === $team->team_leader_id)
                            <a href="{{ route('teams.edit', $team) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('teams.destroy', $team) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this team?')">
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
