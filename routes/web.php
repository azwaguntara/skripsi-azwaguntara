<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenilaianController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\CoprasController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KelompokAlternatifController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenerimaBantuanController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

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
| ROUTE SEMUA USER (ADMIN & PENGGUNA)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ROUTE KHUSUS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('users', UserController::class)
        ->except(['show']);

    Route::patch('/users/{user}/approve', [UserController::class, 'approve'])
        ->name('users.approve');

    Route::patch('/users/{user}/reject', [UserController::class, 'reject'])
        ->name('users.reject');


    /*
    |--------------------------------------------------------------------------
    | DETAIL ALTERNATIF
    |--------------------------------------------------------------------------
    */



    Route::get(
        '/detail-alternatif/{id}',
        [AlternatifController::class, 'detail']
    )->name('alternatif.detail');

    /*
    |--------------------------------------------------------------------------
    | CREATE ALTERNATIF PER DUSUN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/alternatif/create/{kelompok_id}',
        [AlternatifController::class, 'create']
    )->name('alternatif.create');

    /*
    |--------------------------------------------------------------------------
    | RESOURCE ALTERNATIF
    |--------------------------------------------------------------------------
    */

    Route::resource('alternatif', AlternatifController::class)
        ->except(['create', 'show']);

    /*
    |--------------------------------------------------------------------------
    | KELOMPOK / DUSUN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/kelompok/create',
        [KelompokAlternatifController::class, 'create']
    )->name('kelompok.create');

    Route::post(
        '/kelompok/store',
        [KelompokAlternatifController::class, 'store']
    )->name('kelompok.store');

    Route::delete(
        '/kelompok/{id}',
        [KelompokAlternatifController::class, 'destroy']
    )->name('kelompok.destroy');

    /*
    |--------------------------------------------------------------------------
    | KRITERIA
    |--------------------------------------------------------------------------
    */

    Route::resource('kriteria', KriteriaController::class);

    /*
    |--------------------------------------------------------------------------
    | PENILAIAN
    |--------------------------------------------------------------------------
    */

    Route::resource('penilaian', PenilaianController::class);

    /*
    |--------------------------------------------------------------------------
    | SMART
    |--------------------------------------------------------------------------
    */

    Route::get('/smart', [SmartController::class, 'index'])
        ->name('smart.index');

    Route::get('/smart/{id}', [SmartController::class, 'show'])
        ->name('smart.show');

    Route::post('/smart/{id}/tetapkan', [SmartController::class, 'tetapkan'])
        ->name('smart.tetapkan');

    Route::post('/smart/batal-tetapkan/{id}', [SmartController::class, 'batalTetapkan'])
        ->name('smart.batalTetapkan');

    Route::get('/smart/print/{id}', [SmartController::class, 'print'])
        ->name('smart.print');

    Route::get('/smart/download/{id}', [SmartController::class, 'downloadPdf'])
        ->name('smart.download');



    /*
    |--------------------------------------------------------------------------
    | COPRAS
    |--------------------------------------------------------------------------
    */

    Route::get('/copras', [CoprasController::class, 'index'])
        ->name('copras.index');

    Route::get('/copras/{id}', [CoprasController::class, 'show'])
        ->name('copras.show');

    Route::post('/copras/{id}/tetapkan', [CoprasController::class, 'tetapkan'])
        ->name('copras.tetapkan');

    Route::post('/copras/batal-tetapkan/{id}', [CoprasController::class, 'batalTetapkan'])
        ->name('copras.batalTetapkan');

    Route::get('/copras/print/{id}', [CoprasController::class, 'print'])
        ->name('copras.print');

    Route::get('/copras/download/{id}', [CoprasController::class, 'downloadPdf'])
        ->name('copras.download');


    Route::get('/penerima-bantuan', [PenerimaBantuanController::class, 'index'])
        ->name('penerima.index');

    Route::get('/penerima-bantuan/print', [PenerimaBantuanController::class, 'print'])
        ->name('penerima.print');

    Route::get('/penerima-bantuan/pdf', [PenerimaBantuanController::class, 'downloadPdf'])
        ->name('penerima.pdf');
});

Route::get(
    '/verifikasi/smart/{token}',
    [SmartController::class, 'verify']
)->name('smart.verify');

Route::get(
    '/verifikasi/copras/{token}',
    [CoprasController::class, 'verify']
)->name('copras.verify');

Route::get('/verifikasi-penerima/{kelompok_id?}', [PenerimaBantuanController::class, 'verifikasi'])
    ->name('penerima.verifikasi');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
