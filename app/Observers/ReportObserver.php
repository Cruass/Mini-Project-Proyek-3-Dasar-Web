<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\ReportStatusLog;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    public function updated(Report $report): void
    {
        if ($report->wasChanged('status')) {
            ReportStatusLog::create([
                'report_id'   => $report->id,
                'user_id'     => Auth::id(),
                'status_lama' => $report->getOriginal('status'),
                'status_baru' => $report->status,
            ]);
        }
    }
}