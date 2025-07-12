<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\informasiBeritaController;
use App\Http\Controllers\informasiPengumumanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\kegitanKomunitasController;
use App\Http\Controllers\kelolaKategoriKegiatanController;
use App\Http\Controllers\kelolaKomunitasController;
use App\Http\Controllers\kelolaMemberController;
use App\Http\Controllers\kelolaStrukturController;
use App\Http\Controllers\KomunitasController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\programDispusipController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', [RoutingController::class, 'index'])->name('root');

// Route yang membutuhkan middleware 'auth'
Route::middleware('auth')->group(function () {
    Route::get('/check-role', function () {
        if (auth()->user()->role === 'superAdmin') {
            return redirect('/dashboard');
        } else if (auth()->user()->role === 'adminLokal') {
            return redirect('/dashboardLocal');
        }
        return redirect('/login');
    })->name('check-role');
    Route::post('/profile/update/name', [ProfileController::class, 'updateName'])
        ->name('profile.update.name');
    Route::post('/profile/update/email', [ProfileController::class, 'updateEmail'])
        ->name('profile.update.email');
    Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.update.password');

    Route::middleware(['check.role:superAdmin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/Komunitas/komunitas', [KomunitasController::class, 'index'])->name('komunitas');
        Route::get('/Komunitas/members/{kd_komunitas}', [KomunitasController::class, 'showMembers'])->name('komunitas.members');
        Route::prefix('user')->group(function () {
            Route::get('/users', [PendudukController::class, 'index'])->name('penduduk');
            Route::get('/tambahUsers', [PendudukController::class, 'create'])->name('penduduk.create');
            Route::post('/tambahUsers', [PendudukController::class, 'store'])->name('penduduk.store');
            Route::get('/import-csv', [PendudukController::class, 'importCsv'])->name('penduduk.import');
            Route::post('/import-csv', [PendudukController::class, 'storeCsv'])->name('penduduk.import.store');
            Route::get('/download-csv-template', [PendudukController::class, 'downloadCsvTemplate'])->name('penduduk.template');
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
            Route::get('/editStruktur/{id}', [kelolaStrukturController::class, 'edit'])->name('editStruktur');
            Route::put('/editStruktur/{id}', [kelolaStrukturController::class, 'update'])->name('updateStruktur');
            Route::delete('/editStruktur/removeJabatan/{id}/{jabatan_id}', [kelolaStrukturController::class, 'removeJabatan'])->name('removeJabatan');
        });
        Route::prefix('programDispusip')->group(function () {
            Route::post('/programDispusip/{id}/{status}', [programDispusipController::class, 'updateProgramStatus'])->name('programDispusip.updateStatus');
            Route::get('/programDispusip', [programDispusipController::class, 'index'])->name('programDispusip');
            Route::get('/tambahProgram', [programDispusipController::class, 'create'])->name('programDispusip.create');
            Route::post('/tambahProgram', [programDispusipController::class, 'store'])->name('programDispusip.store');
            Route::get('/editProgram/{kd_program}', [programDispusipController::class, 'edit'])->name('programDispusip.edit');
            Route::put('/editProgram/{kd_program}', [programDispusipController::class, 'update'])->name('programDispusip.update');
        });
        Route::prefix('kelolaKegiatan')->group(function () {
            //Program
            Route::get('/kelolaKegiatanProgram', [KegiatanController::class, 'index'])->name('kelolaKegiatan.index');
            Route::get('/tambahKegiatanProgram', [KegiatanController::class, 'create'])->name('kelolaKegiatan.create');
            Route::post('/tambahKegiatanProgram', [KegiatanController::class, 'store'])->name('kelolaKegiatan.store');
            Route::post('/addPhotos', [KegiatanController::class, 'addPhotos'])->name('kelolaKegiatan.addPhotos');
            Route::get('/deletePhoto/{kdFoto}', [KegiatanController::class, 'deletePhoto'])->name('kelolaKegiatan.deletePhoto');
            Route::get('/delete/{kdKegiatan}', [KegiatanController::class, 'delete'])->name('kelolaKegiatan.delete');
            // Komunitas
            Route::get('/kelolaKegiatanKomunitas', [kegitanKomunitasController::class, 'index'])->name('kelolaKegiatan2.index');
            Route::get('/tambahKegiatanKomunitas', [kegitanKomunitasController::class, 'create'])->name('kelolaKegiatan2.create');
            Route::post('/tambahKegiatanKomunitas', [kegitanKomunitasController::class, 'store'])->name('kelolaKegiatan2.store');
            Route::post('/addPhotos2', [kegitanKomunitasController::class, 'addPhotos'])->name('kelolaKegiatan2.addPhotos');
            Route::get('/deletePhoto2/{kdFoto}', [kegitanKomunitasController::class, 'deletePhoto'])->name('kelolaKegiatan2.deletePhoto');
            Route::get('/delete2/{kdKegiatan}', [kegitanKomunitasController::class, 'delete'])->name('kelolaKegiatan2.delete');
        });
        Route::prefix('kelolaKategoriKegiatan')->group(function () {
            Route::get('/kelolaKategoriKegiatan', [kelolaKategoriKegiatanController::class, 'index'])->name('kategori.index');
            Route::post('/store', [kelolaKategoriKegiatanController::class, 'store'])->name('kategori.store');
            Route::put('/update/{kd_katkeg}', [kelolaKategoriKegiatanController::class, 'update'])->name('kategori.update');
            Route::delete('/delete/{kd_katkeg}', [kelolaKategoriKegiatanController::class, 'destroy'])->name('kategori.destroy');
        });
        Route::prefix('kelolaInformasi')->group(function () {
            // Berita
            Route::get('/kelolaInformasiBerita', [informasiBeritaController::class, 'index'])->name('informasiBerita');
            Route::get('/tambahInformasiBerita', [InformasiBeritaController::class, 'create'])->name('informasiBerita.create');
            Route::post('/tambahInformasiBerita', [InformasiBeritaController::class, 'store'])->name('informasiBerita.store');
            Route::get('/editInformasiBerita/{kd_info}', [InformasiBeritaController::class, 'edit'])->name('informasiBerita.edit');
            Route::put('/editInformasiBerita/{kd_info}', [InformasiBeritaController::class, 'update'])->name('informasiBerita.update');
            Route::post('/kelolaInformasiBerita/{kd_info}/{status}', [InformasiBeritaController::class, 'updateInformasiBeritaStatus'])->name('informasiBerita.updateStatus');
            Route::delete('/kelolaInformasiBerita/{kd_info}', [InformasiBeritaController::class, 'destroy'])->name('informasiBerita.destroy');

            // Pengumuman
            Route::get('/kelolaInformasiPengumuman', [informasiPengumumanController::class, 'index'])->name('informasiPengumuman');
            Route::get('/tambahInformasiPengumuman', [informasiPengumumanController::class, 'create'])->name('informasiPengumuman.create');
            Route::post('/tambahInformasiPengumuman', [informasiPengumumanController::class, 'store'])->name('informasiPengumuman.store');
            Route::get('/editInformasiPengumuman/{kd_info}', [informasiPengumumanController::class, 'edit'])->name('informasiPengumuman.edit');
            Route::put('/editInformasiPengumuman/{kd_info}', [informasiPengumumanController::class, 'update'])->name('informasiPengumuman.update');
            Route::post('/kelolaInformasiPengumuman/{kd_info}/{status}', [informasiPengumumanController::class, 'updateInformasiPengumumanStatus'])->name('informasiPengumuman.updateStatus');
            Route::delete('/kelolaInformasiPengumuman/{kd_info}', [informasiPengumumanController::class, 'destroy'])->name('informasiPengumuman.destroy');
        });
    });
    Route::middleware(['check.role:adminLokal'])->group(function () {
        Route::get('/dashboardLokal', [DashboardController::class, 'indexLokal'])->name('dashboardLokal');
        Route::get('/kelolaMember', [KelolaMemberController::class, 'index'])->name('memberLokal');

        Route::group(['prefix' => 'kelolaMemberLokal'], function () {
            Route::get('/{kd_komunitas}/detailMember', [KelolaMemberController::class, 'showMembers'])
                ->name('memberLokal.detail');

            Route::get('/{kd_komunitas}/tambahMember', [KelolaMemberController::class, 'create'])
                ->name('memberLokal.create');

            Route::post('/{kd_komunitas}/tambahMember', [KelolaMemberController::class, 'store'])
                ->name('memberLokal.store');

            Route::get('/{kd_komunitas}/editMember/{kd_member}', [KelolaMemberController::class, 'editMember'])
                ->name('memberLokal.edit');

            Route::put('/{kd_komunitas}/editMember/{kd_member}', [KelolaMemberController::class, 'updateMember'])
                ->name('memberLokal.update');

            Route::delete('/{kd_komunitas}/{kd_member}', [KelolaMemberController::class, 'destroy'])
                ->name('memberLokal.delete');
        });
        Route::group(['prefix' => 'kelolaLaporanLokal'], function () {
            Route::get('/kelolaLaporan', [laporanController::class, 'index'])
                ->name('laporanLokal');
            Route::get('/kelolaLaporan/detailLaporan/{kd_laporan}', [laporanController::class, 'detail'])
                ->name('LaporanLokalDetail');
            Route::post('/kelolaLaporan/detailLaporan/{kd_laporan}', [laporanController::class, 'prosesAction'])
                ->name('LaporanLokalAksi');
            Route::delete('/kelolaLaporan/detailLaporan/{kd_laporan}', [laporanController::class, 'hapusLaporan'])
                ->name('LaporanLokalHapus');
        });
        

        Route::get('/check-ktp', [KelolaMemberController::class, 'checkKtp'])
            ->name('memberLokal.checkKtp');
    });

    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});
