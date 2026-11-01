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
}
