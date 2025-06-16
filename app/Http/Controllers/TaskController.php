<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['team', 'assignedUser'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('tasks.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'team_id' => 'required|exists:teams,id',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date'
        ]);

        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function show(Task $task)
    {
        $task->load(['team', 'assignedUser']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $teams = Team::all();
        $task->load('team.members');
        return view('tasks.edit', compact('task', 'teams'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'team_id' => 'required|exists:teams,id',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date'
        ]);

        $task->update($validated);
        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
