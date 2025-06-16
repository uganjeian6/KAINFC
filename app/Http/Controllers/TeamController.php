<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['leader', 'members'])->get();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $leaders = User::where('role', 'team_leader')->get();
        return view('teams.create', compact('leaders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_leader_id' => 'required|exists:users,id'
        ]);

        Team::create($validated);
        return redirect()->route('teams.index')->with('success', 'Team created successfully');
    }

    public function show(Team $team)
    {
        $team->load(['leader', 'members', 'tasks']);
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $leaders = User::where('role', 'team_leader')->get();
        return view('teams.edit', compact('team', 'leaders'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_leader_id' => 'required|exists:users,id'
        ]);

        $team->update($validated);
        return redirect()->route('teams.show', $team)->with('success', 'Team updated successfully');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted successfully');
    }

    public function addMember(Request $request, Team $team)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $team->members()->attach($validated['user_id']);
        return redirect()->route('teams.show', $team)->with('success', 'Member added successfully');
    }

    public function removeMember(Team $team, User $user)
    {
        $team->members()->detach($user->id);
        return redirect()->route('teams.show', $team)->with('success', 'Member removed successfully');
    }
}
