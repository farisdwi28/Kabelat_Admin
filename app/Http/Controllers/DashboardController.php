<?php

namespace App\Http\Controllers;

use App\Models\informasiBerita;
use App\Models\informasiPengumuman;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;
use App\Models\Kegiatan;
use App\Models\kegitanKomunitas;
use Exception;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
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

    public function indexLokal() {
        try {
            // Only accessible by adminLokal
            if (Auth::user()->role !== 'adminLokal') {
                return redirect()->route('dashboard');
            }
            
            $Komunitas = Komunitas::count();
            $Member = MemberKomunitas::count();
            $Kegiatan = Kegiatan::count();
            $KegiatanKomunitas = kegitanKomunitas::count();
            $Pengumuman = informasiPengumuman::count();
            $Berita = informasiBerita::count();
            
            return view('dashboardLokal.index', compact('Komunitas', 'Member', 'Kegiatan', 'KegiatanKomunitas', 'Pengumuman', 'Berita'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }
}