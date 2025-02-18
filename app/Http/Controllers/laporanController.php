<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class laporanController extends Controller
{
    public function index()
    {
        $adminKdLokal = Auth::user()->kd_lokal;
        $laporan = Laporan::join('member_komunitas', 'laporan.kd_member', '=', 'member_komunitas.kd_member')
            ->join('users', 'member_komunitas.id', '=', 'users.id')
            ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
            ->join('kelurahan_desa', function ($join) use ($adminKdLokal) {
                $join->where('kelurahan_desa.kd_kelurahan', '=', $adminKdLokal);
            })
            ->join('kecamatan', 'kelurahan_desa.kd_kecamatan', '=', 'kecamatan.kd_kecamatan')
            ->whereRaw("UPPER(REPLACE(REPLACE(penduduk.kecamatan, ' ', ''), ',', '')) =
                    UPPER(REPLACE(REPLACE(kecamatan.nm_kecamatan, ' ', ''), ',', ''))
                    COLLATE utf8mb4_general_ci")
            ->get();
        return view('kelolaLaporanLokal.kelolaLaporan', compact('laporan'));
    }

    public function detail($kd_laporan)
    {
        $laporan = Laporan::findorFail($kd_laporan);
        return view('kelolaLaporanLokal.detailLaporan', compact('laporan'));
    }

    public function prosesAction(Request $request, $kd_laporan)
    {
        try {
            $laporan = Laporan::findOrFail($kd_laporan);

            if ($laporan->status_periksa !== 'belum diperiksa') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Laporan sudah diproses sebelumnya.'
                ], 400);
            }

            $action = $request->query('action');

            if ($action === 'terima') {
                $laporan->status_periksa = 'Diterima';
                $laporan->alasan_penolakan = null;
            } elseif ($action === 'tolak') {
                $laporan->status_periksa = 'Ditolak';
                $laporan->alasan_penolakan = $request->alasan ?? '';
            }

            if ($laporan->save()) {
                return response()->json(['status' => 'success', 'message' => 'Berhasil memproses laporan']);
            }

            return response()->json(['status' => 'error', 'message' => 'Gagal memproses laporan'], 500);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function hapusLaporan($kd_laporan)
    {
        try {
            $laporan = Laporan::findOrFail($kd_laporan);
            if ($laporan->file) {
                $filePath = storage_path('app/public/' . $laporan->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $laporan->delete();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus laporan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
