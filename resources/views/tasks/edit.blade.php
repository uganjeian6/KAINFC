@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Task</h2>

            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Task Title</label>
                    <input type="text" name="title" id="title" value="{{ $task->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $task->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="team_id" class="block text-gray-700 text-sm font-bold mb-2">Team</label>
                    <select name="team_id" id="team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ $task->team_id == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Assign To</label>
                    <select name="assigned_to" id="assigned_to" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Unassigned</option>
                        @foreach($teams as $team)
                            <optgroup label="{{ $team->name }}">
                                @foreach($team->members as $member)
                                <option value="{{ $member->id }}" {{ $task->assigned_to == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Task
                    </button>
                    <a href="{{ route('tasks.show', $task) }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
