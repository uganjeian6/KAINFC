<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Task;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('reports.index', compact('teams'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'team_id' => 'nullable|exists:teams,id',
            'status' => 'nullable|in:pending,in_progress,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $query = Task::with(['team', 'assignedUser']);

        if ($request->team_id) {
            $query->where('team_id', $request->team_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $tasks = $query->get();
        $reportData = [
            'tasks' => $tasks,
            'filters' => $request->all(),
            'generated_at' => now()
        ];

        if ($request->print) {
            $pdf = PDF::loadView('reports.print', $reportData);
            return $pdf->download('team-report.pdf');
        }

        return view('reports.show', $reportData);
    }
}
