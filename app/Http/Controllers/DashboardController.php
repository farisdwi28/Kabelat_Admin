<?php

namespace App\Http\Controllers;

use App\Models\informasiBerita;
use App\Models\informasiPengumuman;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;
use App\Models\Kegiatan;
use App\Models\kegitanKomunitas;
use App\Models\kelurahanDesa;
use Exception;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Only accessible by superAdmin
            if (Auth::user()->role !== 'superAdmin') {
                return redirect()->route('dashboardLokal');
            }
            $Komunitas = Komunitas::count();
            $Member = MemberKomunitas::count();
            $Kegiatan = Kegiatan::count();
            $KegiatanKomunitas = kegitanKomunitas::count();
            $Pengumuman = informasiPengumuman::count();
            $Berita = informasiBerita::count();

            return view('dashboard.index', compact('Komunitas', 'Member', 'Kegiatan', 'KegiatanKomunitas', 'Pengumuman', 'Berita'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }

    public function indexLokal()
    {
        try {
            if (Auth::user()->role !== 'adminLokal') {
                return redirect()->route('dashboard');
            }

            $adminKdLokal = Auth::user()->kd_lokal;
            // \Log::info('Admin kd_lokal: ' . $adminKdLokal);

            $kelurahanDesa = kelurahanDesa::where('kd_kelurahan', $adminKdLokal)->first();
            if (!$kelurahanDesa) {
                throw new Exception('Kelurahan not found for kd_lokal: ' . $adminKdLokal);
            }

            $Member = MemberKomunitas::join('users', 'member_komunitas.id', '=', 'users.id')
                ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
                ->join('kelurahan_desa', function ($join) use ($adminKdLokal) {
                    $join->where('kelurahan_desa.kd_kelurahan', '=', $adminKdLokal);
                })
                ->join('kecamatan', 'kelurahan_desa.kd_kecamatan', '=', 'kecamatan.kd_kecamatan')
                ->whereRaw("UPPER(REPLACE(REPLACE(penduduk.kecamatan, ' ', ''), ',', '')) =
                    UPPER(REPLACE(REPLACE(kecamatan.nm_kecamatan, ' ', ''), ',', ''))
                    COLLATE utf8mb4_general_ci")
                ->count();

            // \Log::info('Member count: ' . $Member);

            $Komunitas = Komunitas::count();
            $Kegiatan = Kegiatan::count();
            $KegiatanKomunitas = kegitanKomunitas::count();
            $Pengumuman = informasiPengumuman::count();
            $Berita = informasiBerita::count();

            return view('dashboardLokal.index', compact(
                'Komunitas',
                'Member',
                'Kegiatan',
                'KegiatanKomunitas',
                'Pengumuman',
                'Berita'
            ));
        } catch (Exception $e) {
            // \Log::error('Dashboard error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while fetching data.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
