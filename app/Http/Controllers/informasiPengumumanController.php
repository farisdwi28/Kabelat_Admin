<?php

namespace App\Http\Controllers;

use App\Models\informasiPengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class informasiPengumumanController extends Controller
{
    public function index()
    {
        try {
            $informasiPengumuman = informasiPengumuman::all();
            return view('kelolaInformasi.kelolaInformasiPengumuman', compact('informasiPengumuman'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
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

    private function generateInformasiBeritaCode()
    {
        try {
            $latestInformasi = informasiPengumuman::orderBy('kd_info', 'desc')->first();

            if (!$latestInformasi) {
                return 'P0001';
            }

            $lastNumber = intval(substr($latestInformasi->kd_info, 1));
            $newNumber = $lastNumber + 1;

            return 'P' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate kode komunitas: ' . $e->getMessage());
        }
    }

    public function updateInformasiPengumumanStatus($id, $status)
    {
        try {
            $allowedStatuses = ['draft', 'terbit', 'sembunyi'];

            if (!in_array($status, $allowedStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid. Gunakan "draft", "terbit", dan "sembunyi".'
                ], 400);
            }

            $informasi = informasiPengumuman::findOrFail($id);
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
        return view('kelolaInformasi.tambahInformasiPengumuman');
    }

    public function store(Request $request)
    {
        Log::info('Request data:', $request->all());
        $validator = Validator::make($request->all(), [
            'judul_pengumuman' => 'required|max:250',
            'isi_pengumuman' => 'required',
            'status_info' => 'required|in:draft,terbit,sembunyi',
            'foto' => 'required|image|max:5120|mimes:jpeg,png,jpg,gif',
            'author' => 'required|array',
            'author.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $informasiCode = $this->generateInformasiBeritaCode();
            $sampulPengumuman = $this->convertImageToBase64($request->file('foto'));

            $informasi = new informasiPengumuman();
            $informasi->kd_info = $informasiCode;
            $informasi->judul_pengumuman = $request->judul_pengumuman;
            $informasi->isi_pengumuman = $request->isi_pengumuman;
            $informasi->status_info = 'draft';
            $informasi->tanggal_dibuat = now()->toDateString();
            $informasi->foto_pengumuman = $sampulPengumuman;
            $informasi->author = json_encode($request->author);
            $informasi->save();

            DB::commit();
            return redirect()->route('informasiPengumuman')->with('success', 'Informasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving informasi berita: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan informasi: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        try {
            $informasi = informasiPengumuman::findOrFail($id);
            return view('kelolaInformasi.editInformasiPengumuman', compact('informasi'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Informasi tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul_pengumuman' => 'required|max:250',
            'isi_pengumuman' => 'required',
            'status_info' => 'required|in:draft,terbit,sembunyi',
            'foto' => 'nullable|image|max:5120|mimes:jpeg,png,jpg,gif',
            'author' => 'required|array',
            'author.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Temukan data berdasarkan ID
            $informasi = informasiPengumuman::findOrFail($id);

            // Update data
            $informasi->judul_pengumuman = $request->judul_pengumuman;
            $informasi->isi_pengumuman = $request->isi_pengumuman;
            $informasi->status_info = $request->status_info;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoBase64 = $this->convertImageToBase64($foto);
                $informasi->foto_pengumuman = $fotoBase64;
            }

            // Update author
            $informasi->author = json_encode($request->author);

            // Simpan perubahan
            $informasi->save();

            return redirect()->route('informasiPengumuman')->with('success', 'Informasi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui informasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $informasi = informasiPengumuman::findOrFail($id);
            $informasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pengumuman'
            ], 500);
        }
    }
}
