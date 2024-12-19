<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\kelolaKategoriKegiatanController;
use App\Http\Controllers\kelolaKomunitasController;
use App\Http\Controllers\kelolaStrukturController;
use App\Http\Controllers\KomunitasController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\programDispusipController;
use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// Route yang membutuhkan middleware 'auth'
Route::middleware('auth')->group(function () {
    Route::get('/', [RoutingController::class, 'index'])->name('root');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/Komunitas/komunitas', [KomunitasController::class, 'index'])->name('komunitas');
    Route::get('/Komunitas/members/{kd_komunitas}', [KomunitasController::class, 'showMembers'])->name('komunitas.members');
    Route::prefix('user')->group(function () {
        Route::get('/users', [PendudukController::class, 'index'])->name('penduduk');
        Route::get('/tambahUsers', [PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('/tambahUsers', [PendudukController::class, 'store'])->name('penduduk.store');
        Route::delete('/users/{kd_pen}', [PendudukController::class, 'destroy'])->name('penduduk.delete');
        Route::get('/edit/{kd_pen}', [PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::put('/edit/{kd_pen}', [PendudukController::class, 'update'])->name('penduduk.update');
    });
    Route::prefix('kelolaKomunitas')->group(function () {
        Route::get('/komunitas', [kelolaKomunitasController::class, 'index'])->name('kelolaKomunitas');
        Route::get('/tambahKomunitas', [kelolaKomunitasController::class, 'create'])->name('kelolaKomunitas.create');
        Route::post('/tambahKomunitas', [kelolaKomunitasController::class, 'store'])->name('kelolaKomunitas.store');
        Route::get('/kelola-komunitas/edit/{kd_komunitas}', [kelolaKomunitasController::class, 'edit'])->name('kelolaKomunitas.edit');
        Route::put('/kelola-komunitas/update/{kd_komunitas}', [kelolaKomunitasController::class, 'update'])->name('kelolaKomunitas.update');
        Route::delete('/kelola-komunitas/delete/{kd_komunitas}', [kelolaKomunitasController::class, 'destroy'])->name('kelolaKomunitas.delete');
    });
    Route::prefix('kelolaStruktur')->group(function () {
        Route::get('/kelolaStruktur', [kelolaStrukturController::class, 'index'])->name('kelolaStruktur');
        Route::get('/detailStruktur/{id}', [kelolaStrukturController::class, 'showDetail'])->name('detailStruktur');
    });
    Route::prefix('programDispusip')->group(function () {
        Route::post('/programDispusip/{id}/{status}', [programDispusipController::class, 'updateProgramStatus'])->name('programDispusip.updateStatus');
        Route::get('/programDispusip', [programDispusipController::class, 'index'])->name('programDispusip');
        Route::get('/tambahProgram', [programDispusipController::class, 'create'])->name('programDispusip.create');
        Route::post('/tambahProgram', [programDispusipController::class, 'store'])->name('programDispusip.store');
        Route::get('/editProgram/{kd_program}', [programDispusipController::class, 'edit'])->name('programDispusip.edit');
        Route::put('/editProgram/{kd_program}', [programDispusipController::class, 'update'])->name('programDispusip.update');
    });
    Route::prefix('kelolaKategoriKegiatan')->group(function () {
        Route::get('/kelolaKategoriKegiatan', [kelolaKategoriKegiatanController::class, 'index'])->name('kategori.index');
        Route::post('/store', [kelolaKategoriKegiatanController::class, 'store'])->name('kategori.store');
        Route::put('/update/{kd_katkeg}', [kelolaKategoriKegiatanController::class, 'update'])->name('kategori.update');
        Route::delete('/delete/{kd_katkeg}', [kelolaKategoriKegiatanController::class, 'destroy'])->name('kategori.destroy');
    });
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});
