<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportMonitorController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ReportRecapController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:pelapor'])->group(function () {
    Route::resource('reports', ReportController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
});

Route::middleware(['auth', 'role:relawan,koordinator'])
    ->prefix('pemantauan')
    ->name('monitor.')
    ->group(function () {
        Route::get('/reports', [ReportMonitorController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportMonitorController::class, 'show'])->name('reports.show');
        Route::post('/reports/{report}/review', [ReportMonitorController::class, 'review'])->name('reports.review');
        Route::get('/rekap', [ReportRecapController::class, 'index'])->name('recap');
    });

    Route::middleware('auth')->get('/areas/{area}/summary', [AreaController::class, 'summary'])
    ->name('areas.summary');

require __DIR__.'/auth.php';
