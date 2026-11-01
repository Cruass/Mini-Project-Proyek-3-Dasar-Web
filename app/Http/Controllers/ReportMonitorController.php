<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportMonitorController extends Controller
{
    public function index()
    {
        $reports = Report::with(['area', 'pelapor'])
            ->latest()
            ->paginate(10);

        return view('monitor.index', compact('reports'));
    }

    public function show(Report $report)
    {
        Gate::authorize('view', $report);

        $report->load(['area', 'pelapor', 'reviewer']);

        return view('monitor.show', compact('report'));
    }

    public function review(Request $request, Report $report)
    {
        Gate::authorize('review', $report);

        $request->validate([
            'catatan_relawan' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        if (! $report->bisaDitinjau()) {
            return back()->with('error', 'Hanya laporan berstatus baru yang dapat ditinjau.');
        }

        $report->update([
            'status'          => 'ditinjau',
            'reviewer_id'     => $request->user()->id,
            'catatan_relawan' => $request->catatan_relawan,
        ]);

        return redirect()->route('monitor.reports.show', $report)
            ->with('success', 'Laporan berhasil ditandai sebagai ditinjau.');
    }
}