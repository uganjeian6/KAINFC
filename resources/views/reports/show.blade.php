@extends('layouts.app')

@section('content')
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Task Report</h2>
            <form action="{{ route('reports.generate') }}" method="GET">
                @foreach($filters as $key => $value)
                    @if($value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <input type="hidden" name="print" value="1">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Download PDF
                </button>
            </form>
        </div>

        <div class="mb-4 text-sm text-gray-600">
            <p>Generated at: {{ $generated_at->format('Y-m-d H:i:s') }}</p>
            @if($filters['team_id'])
                <p>Team: {{ $tasks->first()->team->name ?? 'N/A' }}</p>
            @endif
            @if($filters['status'])
                <p>Status: {{ ucfirst($filters['status']) }}</p>
            @endif
            @if($filters['start_date'])
                <p>From: {{ $filters['start_date'] }}</p>
            @endif
            @if($filters['end_date'])
                <p>To: {{ $filters['end_date'] }}</p>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->team->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->assignedUser->name ?? 'Unassigned' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                                   ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($tasks->isEmpty())
        <div class="text-center py-4 text-gray-500">
            No tasks found matching the specified criteria.
        </div>
        @endif
    </div>
</div>
@endsection
