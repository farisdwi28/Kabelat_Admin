<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;

class KomunitasController extends Controller
{
    public function index()
    {
        try {
            $Komunitas = Komunitas::with(['Ketua'])->get();
            return view('Komunitas.komunitas', compact('Komunitas'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function showMembers($kd_komunitas)
    {
        try {
            $komunitas = Komunitas::findOrFail($kd_komunitas);
            
            $members = MemberKomunitas::where('member_komunitas.kd_komunitas', $kd_komunitas)
                ->join('users', 'member_komunitas.id', '=', 'users.id')
                ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
                ->select(
                    'member_komunitas.kd_member',
                    'member_komunitas.kd_jabatan',
                    'member_komunitas.tgl_bergabung',
                    'penduduk.nm_pen as nm_member',
                    'penduduk.kecamatan',
                    'penduduk.RT',
                    'penduduk.RW',
                )
                ->get();

            return view('Komunitas.members', [
                'Komunitas' => $komunitas,
                'Members' => $members
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
