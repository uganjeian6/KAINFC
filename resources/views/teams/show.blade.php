@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">{{ $team->name }}</h2>
                <div class="space-x-2">
                    @if(Auth::user()->role === 'admin' || Auth::user()->id === $team->team_leader_id)
                    <a href="{{ route('teams.edit', $team) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Team
                    </a>
                    @endif
                    <a href="{{ route('teams.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Teams
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Team Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Team Information</h3>
                    <div class="space-y-2">
                        <p><span class="font-bold">Team Leader:</span> {{ $team->leader->name }}</p>
                        <p><span class="font-bold">Description:</span> {{ $team->description ?: 'No description provided' }}</p>
                        <p><span class="font-bold">Created:</span> {{ $team->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Team Members</h3>
                        @if(Auth::user()->role === 'admin' || Auth::user()->id === $team->team_leader_id)
                        <button onclick="document.getElementById('addMemberModal').classList.remove('hidden')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Add Member
                        </button>
                        @endif
                    </div>
                    <div class="space-y-2">
                        @forelse($team->members as $member)
                        <div class="flex justify-between items-center bg-white p-2 rounded">
                            <span>{{ $member->name }}</span>
                            @if(Auth::user()->role === 'admin' || Auth::user()->id === $team->team_leader_id)
                            <form action="{{ route('teams.members.remove', [$team, $member]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure you want to remove this member?')">
                                    Remove
                                </button>
                            </form>
                            @endif
                        </div>
                        @empty
                        <p class="text-gray-500">No members in this team.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Team Tasks -->
                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Team Tasks</h3>
                        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Create Task
                        </a>
                    </div>
                    @if($team->tasks->isEmpty())
                    <p class="text-gray-500">No tasks assigned to this team.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($team->tasks as $task)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $task->assignedUser->name ?? 'Unassigned' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                                               ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div id="addMemberModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Add Team Member</h3>
            <button onclick="document.getElementById('addMemberModal').classList.add('hidden')" class="text-gray-600 hover:text-gray-800">&times;</button>
        </div>
        <form action="{{ route('teams.members.add', $team) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Select Member</label>
                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Select a user</option>
                    @foreach(\App\Models\User::where('role', 'member')->whereNotIn('id', $team->members->pluck('id'))->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addMemberModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
