<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportRecapController extends Controller
{
    public function index(Request $request)
    {
        $tingkat = in_array($request->input('tingkat'), ['ringan', 'sedang', 'berat'])
            ? $request->input('tingkat')
            : null;

        $rows = Report::query()
            ->when($tingkat, fn ($q, $v) => $q->where('tingkat', $v))
            ->selectRaw('area_id, status, COUNT(*) as jumlah')
            ->groupBy('area_id', 'status')
            ->get();

        $statuses = ['baru', 'ditinjau', 'diteruskan', 'selesai'];

        $rekap = Area::orderBy('nama')->get()->map(function ($area) use ($rows, $statuses) {
            $milik = $rows->where('area_id', $area->id);

            $baris = [
                'wilayah' => $area->nama,
                'total'   => (int) $milik->sum('jumlah'),
            ];

            foreach ($statuses as $status) {
                $baris[$status] = (int) $milik->where('status', $status)->sum('jumlah');
            }

            return $baris;
        });

        $total   = (int) $rows->sum('jumlah');
        $selesai = (int) $rows->where('status', 'selesai')->sum('jumlah');

        $ringkasan = [
            'total'   => $total,
            'aktif'   => $total - $selesai,
            'selesai' => $selesai,
            'baru'    => (int) $rows->where('status', 'baru')->sum('jumlah'),
        ];

        return view('monitor.recap', compact('ringkasan', 'rekap', 'tingkat'));
    }
}