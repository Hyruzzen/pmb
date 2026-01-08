<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
