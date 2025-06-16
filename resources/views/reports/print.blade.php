<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Task Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1 {
            color: #1a202c;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .report-info {
            margin-bottom: 20px;
            font-size: 14px;
            color: #4a5568;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f7fafc;
            font-weight: bold;
            color: #4a5568;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-completed {
            background-color: #c6f6d5;
            color: #2f855a;
        }
        .status-in-progress {
            background-color: #fefcbf;
            color: #975a16;
        }
        .status-pending {
            background-color: #e2e8f0;
            color: #4a5568;
        }
        .empty-message {
            text-align: center;
            color: #718096;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Task Report</h1>

    <div class="report-info">
        <p>Generated at: {{ $generated_at->format('Y-m-d H:i:s') }}</p>
        @if(isset($filters['team_id']) && $filters['team_id'])
            <p>Team: {{ $tasks->first()->team->name ?? 'N/A' }}</p>
        @endif
        @if(isset($filters['status']) && $filters['status'])
            <p>Status: {{ ucfirst($filters['status']) }}</p>
        @endif
        @if(isset($filters['start_date']) && $filters['start_date'])
            <p>From: {{ $filters['start_date'] }}</p>
        @endif
        @if(isset($filters['end_date']) && $filters['end_date'])
            <p>To: {{ $filters['end_date'] }}</p>
        @endif
    </div>

    @if($tasks->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Team</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->team->name }}</td>
                <td>{{ $task->assignedUser->name ?? 'Unassigned' }}</td>
                <td>
                    <span class="status status-{{ $task->status }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </td>
                <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-message">
        No tasks found matching the specified criteria.
    </div>
    @endif
</body>
</html>
