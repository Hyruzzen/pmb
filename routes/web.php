<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WELCOME (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PENDAFTARAN PMB (STEP BY STEP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('pendaftaran')
    ->name('pendaftaran.')
    ->group(function () {

        // STEP 1 – DATA DIRI
        Route::get('/', [PendaftaranController::class, 'create'])
            ->name('create');

        Route::post('/', [PendaftaranController::class, 'storeDataDiri'])
            ->name('store');

        // STEP 2 – PRODI
        Route::get('/prodi', [PendaftaranController::class, 'prodi'])
            ->name('prodi');

        Route::post('/prodi', [PendaftaranController::class, 'storeProdi'])
            ->name('prodi.store');

        // STEP 3 – UPLOAD BERKAS
        Route::get('/upload-berkas', [PendaftaranController::class, 'uploadBerkas'])
            ->name('upload');

        Route::post('/upload-berkas', [PendaftaranController::class, 'storeBerkas'])
            ->name('upload.store');

        // STEP 4 – SELESAI
        Route::get('/selesai', [PendaftaranController::class, 'selesai'])
            ->name('selesai');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes (simple role-based)
Route::middleware(['auth','is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftarans/data', [\App\Http\Controllers\Admin\PendaftaranController::class, 'data'])->name('pendaftaran.data');
        Route::get('/pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::get('/pendaftarans/{pendaftaran}/edit', [\App\Http\Controllers\Admin\PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
        Route::put('/pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'update'])->name('pendaftaran.update');
        Route::delete('/pendaftarans/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
    });
