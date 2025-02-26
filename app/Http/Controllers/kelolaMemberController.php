<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;
use App\Models\Penduduk;
use App\Models\strukturJabatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class kelolaMemberController extends Controller
{
    public function index()
    {
        try {
            $Komunitas = Komunitas::with('Ketua2')->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('kelolaMemberLokal.kelolaMember', compact('Komunitas'));
    }

    public function showMembers($kd_komunitas)
    {
        $komunitas = Komunitas::findOrFail($kd_komunitas);
        $adminKdLokal = Auth::user()->kd_lokal;
        $members = MemberKomunitas::join('users', 'member_komunitas.id', '=', 'users.id')
            ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
            ->join('kelurahan_desa', function ($join) use ($adminKdLokal) {
                $join->where('kelurahan_desa.kd_kelurahan', '=', $adminKdLokal);
            })
            ->join('kecamatan', 'kelurahan_desa.kd_kecamatan', '=', 'kecamatan.kd_kecamatan')
            ->whereRaw("UPPER(REPLACE(REPLACE(penduduk.kecamatan, ' ', ''), ',', '')) =
                    UPPER(REPLACE(REPLACE(kecamatan.nm_kecamatan, ' ', ''), ',', ''))
                    COLLATE utf8mb4_general_ci")
            ->get();

        return view('kelolaMemberLokal.detailMember', compact('komunitas', 'members'));
    }

    public function create($kd_komunitas)
    {
        $komunitas = Komunitas::findOrFail($kd_komunitas);
        return view('kelolaMemberLokal.tambahMember', compact('komunitas'));
    }

    private function generateMemberCode()
    {
        try {
            $latestMember = MemberKomunitas::orderBy('kd_member', 'desc')->first();

            if (!$latestMember) {
                return 'P0002';
            }
            $lastNumber = intval(substr($latestMember->kd_member, 1));
            $newNumber = $lastNumber + 1;

            return 'P' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate kode komunitas: ' . $e->getMessage());
        }
    }

    public function checkKtp(Request $request)
    {
        $no_ktp = $request->input('no_ktp');
        $penduduk = Penduduk::where('no_ktp', $no_ktp)->first();

        if ($penduduk) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nm_pen' => $penduduk->nm_pen,
                    'desa' => $penduduk->desa,
                    'RT' => $penduduk->RT,
                    'RW' => $penduduk->RW,
                    'kecamatan' => $penduduk->kecamatan
                ]
            ], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Nomor KTP tidak ditemukan di database.'], 404);
    }

    public function store(Request $request, $kd_komunitas)
    {
        $request->validate([
            'no_ktp' => 'required|string|size:16',
            'nm_pen' => 'required|string|max:255',
            'RT' => 'required|integer',
            'RW' => 'required|integer',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
        ]);

        try {
            $no_ktp = $request->no_ktp;

            $penduduk = Penduduk::where('no_ktp', $no_ktp)->first();

            if ($penduduk && $penduduk->user) {
                return redirect()->back()->with('error', 'Penduduk sudah terdaftar sebagai member.');
            }

            if (!$penduduk) {
                $penduduk = new Penduduk();
                $penduduk->no_ktp = $no_ktp;
                $penduduk->nm_pen = $request->nm_pen;
                $penduduk->RT = $request->RT;
                $penduduk->RW = $request->RW;
                $penduduk->desa = $request->desa;
                $penduduk->kecamatan = $request->kecamatan;
                $penduduk->save();
            }

            $user = User::where('kd_pen', $penduduk->kd_pen)->first();

            if ($user) {
                $username = $user->username;
                $email = $user->email;
            } else {
                $username = 'member_' . $penduduk->no_ktp;
                $email = $penduduk->no_ktp . '@gmail.com';
                $randomPassword = 'Password';
                $hashedPassword = Hash::make($randomPassword);

                if (User::where('username', $username)->exists()) {
                    return redirect()->back()->with('error', 'Username sudah digunakan.');
                }
                if (User::where('email', $email)->exists()) {
                    return redirect()->back()->with('error', 'Email sudah digunakan.');
                }

                $user = new User();
                $user->name = $penduduk->nm_pen;
                $user->username = $username;
                $user->email = $email;
                $user->password = $hashedPassword;
                $user->role = 'user';
                $user->email_verified_at = now();
                $user->kd_lokal = Auth::user()->kd_lokal;
                $user->kd_pen = $penduduk->kd_pen;
                $user->remember_token = Str::random(10);
                $user->save();
            }

            $kd_jabatan = strukturJabatan::where('nm_jabatan', 'Anggota')->value('kd_jabatan');

            if (!$kd_jabatan) {
                return redirect()->back()->with('error', 'Kode jabatan untuk "Anggota" tidak ditemukan.');
            }

            // $memberCode = $this->generateMemberCode();

            $member = new MemberKomunitas();
            $member->kd_member = $penduduk->kd_pen;
            $member->tgl_bergabung = now();
            $member->id = $user->id;
            $member->kd_komunitas = $kd_komunitas;
            $member->kd_jabatan = $kd_jabatan;
            $member->save();

            return redirect()->route('memberLokal.detail', $kd_komunitas)
                ->with('success', 'Member berhasil ditambahkan dengan username: ' . $username . ' dan password: ' . ($user->wasRecentlyCreated ? $randomPassword : 'Sudah ada'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editMember($kd_komunitas, $kd_member)
    {
        $member = MemberKomunitas::where('kd_member', $kd_member)
            ->where('kd_komunitas', $kd_komunitas)
            ->with(['user', 'user.penduduk'])
            ->firstOrFail();
    
        $penduduk = $member->user->penduduk;
    
        $komunitas = Komunitas::findOrFail($kd_komunitas);
        $jabatan = $komunitas->jabatan;
    
        return view('kelolaMemberLokal.editMember', compact('member', 'penduduk', 'jabatan'));
    }

    public function updateMember(Request $request, $kd_komunitas, $kd_member)
    {
        $member = MemberKomunitas::with(['user', 'user.penduduk'])
            ->where('kd_member', $kd_member)
            ->where('kd_komunitas', $kd_komunitas)
            ->firstOrFail();

        $penduduk = $member->user->penduduk;

        $request->validate([
            'jk' => 'required',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required',
            'no_hp' => 'required',
            'RT' => 'required',
            'RW' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'alamat' => 'required',
            'kd_jabatan' => 'required|exists:struktur_jabatan,kd_jabatan',
        ]);

        try {
            if ($member->kd_jabatan != $request->kd_jabatan) {
                $member->kd_jabatan = $request->kd_jabatan;
                $member->save();
            }

            $penduduk->jk = $request->jk;
            $penduduk->tgl_lahir = $request->tgl_lahir;
            $penduduk->tempat_lahir = $request->tempat_lahir;
            $penduduk->no_hp = $request->no_hp;
            $penduduk->RT = $request->RT;
            $penduduk->RW = $request->RW;
            $penduduk->desa = $request->desa;
            $penduduk->kecamatan = $request->kecamatan;
            $penduduk->alamat = $request->alamat;

            $penduduk->save();

            return redirect()->route('memberLokal.detail', $kd_komunitas)
                ->with('success', 'Data penduduk dan jabatan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($kd_komunitas, $kd_member)
    {
        try {
            $member = MemberKomunitas::where('kd_member', $kd_member)
                ->where('kd_komunitas', $kd_komunitas)
                ->firstOrFail();

            if ($member) {
                $member->delete();
                return response()->json([
                    'message' => 'Member berhasil dihapus dari komunitas.'
                ]);
            }

            return response()->json([
                'message' => 'Member tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
