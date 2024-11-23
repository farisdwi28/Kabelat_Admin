<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        try {
            $Penduduk = Penduduk::get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('user.users', compact('Penduduk'));
    }

    public function create()
    {
        return view('user.tambahUsers');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nm_pen' => 'required|string|max:255',
                'jk' => 'required|in:Laki-laki,Perempuan',
                'tgl_lahir' => 'required|date',
                'tempat_lahir' => 'required|string|max:255',
                'alamat' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $penduduk = new Penduduk();
            $penduduk->kd_pen = $this->generateKodePenduduk();
            $penduduk->nm_pen = $validated['nm_pen'];
            $penduduk->jk = $validated['jk'];
            $penduduk->tgl_lahir = $validated['tgl_lahir'];
            $penduduk->tempat_lahir = $validated['tempat_lahir'];
            $penduduk->alamat = $validated['alamat'];

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $base64Image = $this->convertImageToBase64($image);
                $penduduk->foto_pen = $base64Image;
            }

            $penduduk->save();

            return redirect()
                ->route('penduduk')
                ->with('success', 'Data Penduduk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function generateKodePenduduk()
    {
        try {
            $latestPenduduk = Penduduk::orderBy('kd_pen', 'desc')->first();

            if (!$latestPenduduk) {
                return 'P001';
            }

            $lastNumber = intval(substr($latestPenduduk->kd_pen, 1));
            $newNumber = $lastNumber + 1;

            return 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate kode penduduk: ' . $e->getMessage());
        }
    }


    public function edit($kd_pen)
    {
        try {
            $Penduduk = Penduduk::find($kd_pen);
            return view('user.edit', compact('Penduduk'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Penduduk tidak ditemukan');
        }
    }

    public function update(Request $request, $kd_pen)
    {
        try {
            // Validasi input
            $request->validate([
                'nm_pen' => 'required|string|max:255',
                'jk' => 'required|in:Laki-laki,Perempuan',
                'tgl_lahir' => 'required|date',
                'tempat_lahir' => 'required|string|max:255',
                'alamat' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Ambil data penduduk berdasarkan ID
            $Penduduk = Penduduk::findOrFail($kd_pen);

            // Update data umum
            $Penduduk->nm_pen = $request->nm_pen;
            $Penduduk->jk = $request->jk;
            $Penduduk->tgl_lahir = $request->tgl_lahir;
            $Penduduk->tempat_lahir = $request->tempat_lahir;
            $Penduduk->alamat = $request->alamat;

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                // dd($image);
                $base64Image = $this->convertImageToBase64($image);
                $Penduduk->foto_pen = $base64Image;
            }

            $Penduduk->save();

            return redirect()->route('penduduk')->with('success', 'Data Penduduk berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
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

            // Encode ke Base64
            $base64Image = 'data:' . $mimeType . ';base64,' . base64_encode($imageContent);

            return $base64Image;
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengonversi gambar: ' . $e->getMessage());
        }
    }

    public function destroy($kd_pen)
    {
        try {
            $Penduduk = Penduduk::findOrFail($kd_pen);
            $Penduduk->delete();
            return redirect()->route('penduduk')->with('success', 'Data Penduduk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('penduduk')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
