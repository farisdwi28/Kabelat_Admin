<?php

namespace App\Http\Controllers;

use App\Models\informasiBerita;
use App\Models\informasiPengumuman;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;
use App\Models\Kegiatan;
use App\Models\kegitanKomunitas;
use Exception;

class DashboardController extends Controller
{
    public function index() {
        try {
            
            $Komunitas = Komunitas::count();
            $Member = MemberKomunitas::count();
            $Kegiatan = Kegiatan::count();
            $KegiatanKomunitas = kegitanKomunitas::count();
            $Pengumuman = informasiPengumuman::count();
            $Berita = informasiBerita::count();
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
        return view('dashboard.index', compact('Komunitas', 'Member', 'Kegiatan', 'KegiatanKomunitas', 'Pengumuman', 'Berita'));
    }
    
}
