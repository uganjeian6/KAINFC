@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h2>
                <div class="space-x-2">
                    @if(Auth::user()->role === 'admin' || Auth::user()->id === $task->team->team_leader_id || Auth::user()->id === $task->assigned_to)
                    <a href="{{ route('tasks.edit', $task) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Task
                    </a>
                    @endif
                    <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Tasks
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Task Details -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Task Details</h3>
                    <div class="space-y-3">
                        <p><span class="font-bold">Description:</span><br>{{ $task->description }}</p>
                        <p><span class="font-bold">Team:</span> {{ $task->team->name }}</p>
                        <p><span class="font-bold">Assigned To:</span> {{ $task->assignedUser->name ?? 'Unassigned' }}</p>
                        <p>
                            <span class="font-bold">Status:</span>
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                                   ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </p>
                        <p><span class="font-bold">Due Date:</span> {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</p>
                        <p><span class="font-bold">Created:</span> {{ $task->created_at->format('M d, Y H:i') }}</p>
                        <p><span class="font-bold">Last Updated:</span> {{ $task->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    @if(Auth::user()->id === $task->assigned_to || Auth::user()->role === 'admin' || Auth::user()->id === $task->team->team_leader_id)
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <input type="hidden" name="team_id" value="{{ $task->team_id }}">
                        <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                        <input type="hidden" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">

                        <div>
                            <label for="quick_status" class="block text-gray-700 text-sm font-bold mb-2">Update Status</label>
                            <select name="status" id="quick_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Status
                        </button>
                    </form>

                    @if(Auth::user()->role === 'admin' || Auth::user()->id === $task->team->team_leader_id)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this task?')">
                            Delete Task
                        </button>
                    </form>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
