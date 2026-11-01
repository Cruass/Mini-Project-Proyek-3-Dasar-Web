<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Area;
use Illuminate\Http\Request;

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
        $request->user()->reports()->create(
            $request->validated() + ['status' => 'baru']
        );

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
}