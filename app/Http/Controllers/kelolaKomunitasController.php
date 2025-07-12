<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;
use App\Models\MemberKomunitas;

class kelolaKomunitasController extends Controller
{
    public function index()
    {
        try {
            $Komunitas = Komunitas::with('Ketua')->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('kelolaKomunitas.komunitas', compact('Komunitas'));
    }

    public function create()
    {
        return view('kelolaKomunitas.tambahKomunitas');
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nm_komunitas' => 'required|string|max:50|unique:komunitas',
                'desk_komunitas' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // $ketua = MemberKomunitas::where('nm_member', $request->input('nm_ketua'))->first();

            if ($request->hasFile('foto')) {
                $logoBase64 = $this->convertImageToBase64($request->file('foto'));
            } else {
                throw new \Exception('Logo komunitas tidak valid.');
            }

            $Komunitas = new Komunitas();
            $Komunitas->nm_komunitas = $validatedData['nm_komunitas'];
            $Komunitas->status = 'Aktif';
            $Komunitas->tanggal_dibuat = now()->toDateString();
            $Komunitas->desk_komunitas = $validatedData['desk_komunitas'];
            $Komunitas->logo = $logoBase64;
            $Komunitas->kd_komunitas = $this->generateKodeKomunitas();
            $Komunitas->save();


            return redirect()->route('kelolaKomunitas')->with('success', 'Komunitas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan komunitas: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function generateKodeKomunitas()
    {
        try {
            $latestKomunitas = Komunitas::orderBy('kd_komunitas', 'desc')->first();

            if (!$latestKomunitas) {
                return 'K0001';
            }

            $lastNumber = intval(substr($latestKomunitas->kd_komunitas, 1));
            $newNumber = $lastNumber + 1;

            return 'K' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate kode komunitas: ' . $e->getMessage());
        }
    }

    private function convertImageToBase64($image)
    {
        try {
            if (!$image->isValid()) {
                throw new \Exception('File tidak valid.');
            }

            $imageContent = file_get_contents($image);
            $mimeType = $image->getMimeType();

            return 'data:' . $mimeType . ';base64,' . base64_encode($imageContent);
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengonversi gambar: ' . $e->getMessage());
        }
    }

    public function edit($kd_komunitas)
    {
        try {
            $Komunitas = Komunitas::findOrFail($kd_komunitas);
            $ketua = MemberKomunitas::where('kd_komunitas', $kd_komunitas)
                ->where('kd_jabatan', 'KETUA')
                ->first();

            return view('kelolaKomunitas.editKomunitas', compact('Komunitas', 'ketua'));
        } catch (\Exception $e) {
            return redirect()
                ->route('kelolaKomunitas')
                ->with('error', 'Gagal menemukan komunitas: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kd_komunitas)
    {
        try {
            $Komunitas = Komunitas::findOrFail($kd_komunitas);

            $validatedData = $request->validate([
                'nm_komunitas' => 'required|string|max:50|unique:komunitas,nm_komunitas,' . $kd_komunitas . ',kd_komunitas',
                'desk_komunitas' => 'required|string',
                'status' => 'required|in:Aktif,Tidak Aktif',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $Komunitas->nm_komunitas = $validatedData['nm_komunitas'];
            $Komunitas->desk_komunitas = $validatedData['desk_komunitas'];
            $Komunitas->status = $validatedData['status'];
            if ($request->hasFile('foto')) {
                $logoBase64 = $this->convertImageToBase64($request->file('foto'));
                $Komunitas->logo = $logoBase64;
            }

            $Komunitas->save();

            return redirect()
                ->route('kelolaKomunitas')
                ->with('success', 'Komunitas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui komunitas: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy($kd_komunitas)
    {
        try {
            $Komunitas = Komunitas::findOrFail($kd_komunitas);
            MemberKomunitas::where('kd_komunitas', $kd_komunitas)->delete();
            $Komunitas->delete();

            return redirect()
                ->route('kelolaKomunitas')
                ->with('success', 'Komunitas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('kelolaKomunitas')
                ->with('error', 'Gagal menghapus komunitas: ' . $e->getMessage());
        }
    }
}
