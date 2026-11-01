<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
    'user_id', 'area_id', 'reviewer_id', 'judul', 'kondisi', 'tingkat',
    'latitude', 'longitude', 'waktu_kejadian', 'status',
    'catatan_relawan', 'diteruskan_ke', 'diteruskan_pada', 'evidence_path',
];

protected $casts = [
    'waktu_kejadian' => 'datetime',
    'diteruskan_pada' => 'datetime',
];

public function pelapor()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function reviewer()
{
    return $this->belongsTo(User::class, 'reviewer_id');
}

public function area()
{
    return $this->belongsTo(Area::class);
}

public function statusLogs()
{
    return $this->hasMany(ReportStatusLog::class);
}

public function bisaDiedit(): bool
{
    return $this->status === 'baru';
}

public function bisaDitinjau(): bool
{
    return $this->status === 'baru';
}

public function bisaDiteruskan(): bool
{
    return $this->status === 'ditinjau';
}

public function bisaDiselesaikan(): bool
{
    return $this->status === 'diteruskan';
}

public function punyaCatatanRelawan(): bool
{
    return filled($this->catatan_relawan);
}

public function scopeFilter($query, array $filters)
{
    return $query
        ->when($filters['q'] ?? null, function ($q, $kata) {
            $q->where(function ($q) use ($kata) {
                $q->where('judul', 'like', "%{$kata}%")
                  ->orWhere('kondisi', 'like', "%{$kata}%");
            });
        })
        ->when($filters['area_id'] ?? null, fn ($q, $area) => $q->where('area_id', $area))
        ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
        ->when($filters['tingkat'] ?? null, fn ($q, $tingkat) => $q->where('tingkat', $tingkat));
}

}
