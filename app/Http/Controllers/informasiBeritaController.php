<?php

namespace App\Http\Controllers;

use App\Models\informasiBerita;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class informasiBeritaController extends Controller
{
    private function getKecamatanList()
    {
        return Kecamatan::whereNotNull('nm_kecamatan')
            ->where('nm_kecamatan', '!=', '')
            ->pluck('nm_kecamatan', 'kd_kecamatan');
    }

    public function index()
    {
        try {
            $informasiBerita = InformasiBerita::with('kecamatan')->get();
            return view('kelolaInformasi.kelolaInformasiBerita', compact('informasiBerita'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    private function getEnumValues($table, $column)
    {
        $type = DB::select("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND COLUMN_NAME = ?", [$table, $column])[0]->COLUMN_TYPE;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        return str_getcsv($matches[1], ',', "'");
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

    private function generateInformasiBeritaCode()
    {
        try {
            $latestInformasi = informasiBerita::orderBy('kd_info', 'desc')->first();

            if (!$latestInformasi) {
                return 'B0001';
            }

            $lastNumber = intval(substr($latestInformasi->kd_info, 1));
            $newNumber = $lastNumber + 1;

            return 'B' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate kode komunitas: ' . $e->getMessage());
        }
    }

    public function updateInformasiBeritaStatus($id, $status)
    {
        try {
            $allowedStatuses = ['draft', 'terbit', 'sembunyi'];

            if (!in_array($status, $allowedStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid. Gunakan "draft", "terbit", dan "sembunyi".'
                ], 400);
            }

            $informasi = informasiBerita::findOrFail($id);
            $informasi->status_info = $status;
            $informasi->save();

            return response()->json([
                'success' => true,
                'message' => "Status program berhasil diubah menjadi $status",
                'status' => $status
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Program tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error("Error updating program status for ID $id: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    public function create()
    {
        $kategoriList = $this->getEnumValues('informasi', 'kategori_berita');
        $kecamatanList = $this->getKecamatanList();
        return view('kelolaInformasi.tambahInformasiBerita', compact('kategoriList', 'kecamatanList'));
    }

    public function store(Request $request)
    {
        Log::info('Request data:', $request->all());
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|max:250',
            'isi_berita' => 'required',
            'status_info' => 'required|in:draft,terbit,sembunyi',
            'kategori_berita' => 'required|in:semua berita,kegiatan,layanan,koleksi,fasilitas,prestasi,kerjasama,events',
            'foto' => 'required|image|max:5120|mimes:jpeg,png,jpg,gif',
            'author' => 'required|array',
            'author.*' => 'string|max:50',
            'kd_kecamatan' => 'required|exists:kecamatan,kd_kecamatan',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $informasiCode = $this->generateInformasiBeritaCode();
            $sampulBerita = $this->convertImageToBase64($request->file('foto'));

            $informasi = new InformasiBerita();
            $informasi->kd_info = $informasiCode;
            $informasi->judul_berita = $request->judul_berita;
            $informasi->isi_berita = $request->isi_berita;
            $informasi->status_info = 'draft';
            $informasi->tanggal_dibuat = now()->toDateString();
            $informasi->kategori_berita = $request->kategori_berita;
            $informasi->foto_berita = $sampulBerita;
            $informasi->author = json_encode($request->author);
            $informasi->kd_kecamatan = $request->kd_kecamatan;
            $informasi->save();

            DB::commit();
            return redirect()->route('informasiBerita')->with('success', 'Informasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Error saving informasi berita: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Berita gagal ditambahkan. Berita telah ada sebelumnya.');
        }
    }


    public function edit($id)
    {
        try {
            $informasi = InformasiBerita::with('kecamatan')->findOrFail($id);
            $kecamatanList = $this->getKecamatanList();
            return view('kelolaInformasi.editInformasiBerita', compact('informasi', 'kecamatanList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Informasi tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|max:250',
            'isi_berita' => 'required',
            'status_info' => 'required|in:draft,terbit,sembunyi',
            'kategori_berita' => 'required|in:semua berita,kegiatan,layanan,koleksi,fasilitas,prestasi,kerjasama,events',
            'foto' => 'nullable|image|max:5120|mimes:jpeg,png,jpg,gif',
            'author' => 'required|array',
            'author.*' => 'string|max:50',
            'kd_kecamatan' => 'required|exists:kecamatan,kd_kecamatan',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $informasi = InformasiBerita::findOrFail($id);

            $informasi->judul_berita = $request->judul_berita;
            $informasi->isi_berita = $request->isi_berita;
            $informasi->status_info = $request->status_info;
            $informasi->kategori_berita = $request->kategori_berita;
            $informasi->kd_kecamatan = $request->kd_kecamatan;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoBase64 = $this->convertImageToBase64($foto);
                $informasi->foto_berita = $fotoBase64;
            }

            $informasi->author = json_encode($request->author);

            $informasi->save();

            return redirect()->route('informasiBerita')->with('success', 'Informasi berhasil diperbarui');
        } catch (\Exception $e) {
            // \Log::error('error', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memperbarui informasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $informasi = InformasiBerita::findOrFail($id);
            $informasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus berita'
            ], 500);
        }
    }
}
