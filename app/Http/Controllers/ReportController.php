<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $filters = $request->only(['q', 'area_id', 'status', 'tingkat']);

    $reports = $request->user()->reports()
        ->with('area')
        ->filter($filters)
        ->latest()
        ->paginate(10);
        ->withQueryString();

    $areas = Area::orderBy('nama')->get();

    return view('reports.index', compact('reports', 'areas'));
}

    public function create()
    {
        $areas = Area::orderBy('nama')->get();

        return view('reports.create', compact('areas'));
    }

    public function store(ReportRequest $request)
    {
        $data = $request->validated();
        unset($data['evidence']);

        if ($request->hasFile('evidence')) {
            $data['evidence_path'] = $request->file('evidence')->store('evidence', 'public');
        }

        $request->user()->reports()->create($data + ['status' => 'baru']);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    public function show(Report $report)
    {
        Gate::authorize('view', $report);

        $report->load(['area', 'reviewer']);

        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        Gate::authorize('update', $report);

        if (! $report->bisaDiedit()) {
            abort(403, 'Laporan yang sudah diproses tidak dapat diubah.');
        }

        $areas = Area::orderBy('nama')->get();

        return view('reports.edit', compact('report', 'areas'));
    }

    public function update(ReportRequest $request, Report $report)
    {
        Gate::authorize('update', $report);

        if (! $report->bisaDiedit()) {
            abort(403, 'Laporan yang sudah diproses tidak dapat diubah.');
        }

        $data = $request->validated();
        unset($data['evidence']);

        if ($request->hasFile('evidence')) {
            if ($report->evidence_path) {
                Storage::disk('public')->delete($report->evidence_path);
            }
            $data['evidence_path'] = $request->file('evidence')->store('evidence', 'public');
        }

        $report->update($data);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}