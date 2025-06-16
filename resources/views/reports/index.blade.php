@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Generate Report</h2>
    </div>

    <div class="card-content">
        <form action="{{ route('reports.generate') }}" method="GET" class="report-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="team_id" class="form-label">Team</label>
                    <select name="team_id" id="team_id" class="form-select">
                        <option value="">All Teams</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-input">
                </div>

                <div class="form-group">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-input">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    View Report
                </button>
                <button type="submit" name="print" value="1" class="btn btn-secondary">
                    Download PDF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
