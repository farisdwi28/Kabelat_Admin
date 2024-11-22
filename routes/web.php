<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomunitasController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// Route yang membutuhkan middleware 'auth'
Route::middleware('auth')->group(function () {
    Route::get('/', [RoutingController::class, 'index'])->name('root');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/Komunitas/komunitas', [KomunitasController::class, 'index'])->name('komunitas');
    Route::get('/Komunitas/members/{kd_komunitas}', [KomunitasController::class, 'showMembers'])->name('komunitas.members');
    Route::get('/user/users', [PendudukController::class, 'index'])->name('penduduk');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});
