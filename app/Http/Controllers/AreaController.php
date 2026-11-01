<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Report;
use Illuminate\Support\Carbon;

class AreaController extends Controller
{
    public function summary(Area $area)
    {
        $aktif = Report::where('area_id', $area->id)
            ->where('status', '!=', 'selesai');

        $perTingkat = (clone $aktif)
            ->selectRaw('tingkat, COUNT(*) as total')
            ->groupBy('tingkat')
            ->pluck('total', 'tingkat');

        $terakhir = (clone $aktif)->max('waktu_kejadian');

        return response()->json([
            'area'         => $area->nama,
            'jumlah_aktif' => $perTingkat->sum(),
            'ringan'       => $perTingkat['ringan'] ?? 0,
            'sedang'       => $perTingkat['sedang'] ?? 0,
            'berat'        => $perTingkat['berat'] ?? 0,
            'terakhir'     => $terakhir ? Carbon::parse($terakhir)->format('d M Y H:i') : null,
        ]);
    }
}