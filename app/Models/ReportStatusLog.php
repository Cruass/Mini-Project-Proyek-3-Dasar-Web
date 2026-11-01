<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatusLog extends Model
{
    protected $fillable = ['report_id', 'user_id', 'status_lama', 'status_baru'];

public function report()
{
    return $this->belongsTo(Report::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
