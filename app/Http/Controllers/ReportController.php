<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = $request->user()->reports()
            ->with('area')
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
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

    public function show(Request $request, $id)
    {
        $report = $request->user()->reports()
            ->with(['area', 'reviewer'])
            ->findOrFail($id);

        return view('reports.show', compact('report'));
    }

    public function edit(Request $request, $id)
    {
        $report = $request->user()->reports()->findOrFail($id);

        if (! $report->bisaDiedit()) {
            abort(403, 'Laporan yang sudah diproses tidak dapat diubah.');
        }

        $areas = Area::orderBy('nama')->get();

        return view('reports.edit', compact('report', 'areas'));
    }

    public function update(ReportRequest $request, $id)
    {
        $report = $request->user()->reports()->findOrFail($id);

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

        return redirect()->route('reports.show', $report->id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}