<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kegitanKomunitas;
use App\Models\kategoriKegiatan;
use App\Models\FotoKegiatan;
use App\Models\Komunitas;
// use App\Models\Kegiatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class kegitanKomunitasController extends Controller
{
    public function index()
    {
        $kegiatan = kegitanKomunitas::with(['komunitas', 'kategori', 'fotoKegiatan'])->get();

        foreach ($kegiatan as $k) {
            $newStatus = $this->determineStatus($k->tgl_mulai, $k->tgl_berakhir);
            $k->update(['status' => $newStatus]);
        }

        return view('kelolaKegiatan.kelolaKegiatanKomunitas', compact('kegiatan'));
    }

    private function determineStatus($startDate, $endDate)
    {
        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        $startDate = Carbon::parse($startDate, 'Asia/Jakarta')->startOfDay();
        $endDate = Carbon::parse($endDate, 'Asia/Jakarta')->endOfDay();

        if ($today->gte($startDate) && $today->lte($endDate)) {
            return 'Sedang Berlangsung';
        } elseif ($today->lt($startDate)) {
            return 'Segera Hadir';
        } else {
            return 'Selesai';
        }
    }

    public function create()
    {
        $komunitas = Komunitas::all();
        $categories = kategoriKegiatan::all();
        $kecamatanList = $this->getEnumValues('kegiatan_komunitas', 'kecamatan');
        $kelurahanList = $this->getEnumValues('kegiatan_komunitas', 'kelurahan');

        return view('kelolaKegiatan.tambahKegiatanKomunitas', compact(
            'komunitas',
            'categories',
            'kecamatanList',
            'kelurahanList'
        ));
    }

    public function store(Request $request)
    {
        try {
            // Validasi dasar
            $request->validate([
                'nm_keg' => 'required',
                'desk_keg' => 'required|string|max:4294967295',
                'tgl_mulai' => 'required|date',
                'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
                'link_keg' => 'nullable|url',
                'lokasi_keg' => 'required',
                'kd_komunitas' => 'required|exists:komunitas,kd_komunitas',
                'kd_katkeg' => 'required|exists:kategori_kegiatan,kd_katkeg',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
            ], [
                'tgl_berakhir.after_or_equal' => 'Tanggal berakhir harus sama dengan atau setelah tanggal mulai',
                'link_keg.url' => 'Format link kegiatan tidak valid',
            ]);

            // Validasi foto
            if (!$request->hasFile('photos')) {
                return back()
                    ->withInput()
                    ->with('error', 'Anda harus mengunggah minimal 1 foto');
            }

            $photos = $request->file('photos');

            // Validasi jumlah foto
            if (count($photos) > 10) {
                return back()
                    ->withInput()
                    ->with('error', 'Maksimal 10 foto yang dapat diunggah. Anda mengunggah ' . count($photos) . ' foto.');
            }

            // Validasi setiap foto
            $totalSize = 0;
            foreach ($photos as $index => $photo) {
                $totalSize += $photo->getSize();

                if (!in_array($photo->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
                    return back()
                        ->withInput()
                        ->with('error', 'Foto ke-' . ($index + 1) . ' harus berformat JPG, JPEG, atau PNG');
                }

                if ($photo->getSize() > (5 * 1024 * 1024)) {
                    return back()
                        ->withInput()
                        ->with('error', 'Foto ke-' . ($index + 1) . ' melebihi batas ukuran 5MB');
                }
            }

            if ($totalSize > (20 * 1024 * 1024)) {
                return back()
                    ->withInput()
                    ->with('error', 'Total ukuran foto melebihi 20MB. Total ukuran saat ini: ' .
                        number_format($totalSize / (1024 * 1024), 2) . 'MB');
            }

            DB::beginTransaction();

            // Generate kode kegiatan
            $lastCode = kegitanKomunitas::orderBy('kd_kegiatan2', 'desc')->first();
            $newNumber = 1;

            if ($lastCode) {
                $lastNumber = (int)substr($lastCode->kd_kegiatan2, 2);
                $newNumber = $lastNumber + 1;
            }

            $newCode = sprintf("KK%03d", $newNumber);

            // Determine initial status based on dates
            $status = $this->determineStatus($request->tgl_mulai, $request->tgl_berakhir);

            // Simpan kegiatan
            $kegiatan = kegitanKomunitas::create([
                'kd_kegiatan2' => $newCode,
                'nm_keg' => $request->nm_keg,
                'desk_keg' => $request->desk_keg,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_berakhir' => $request->tgl_berakhir,
                'link_keg' => $request->link_keg,
                'lokasi_keg' => $request->lokasi_keg,
                'kd_komunitas' => $request->kd_komunitas,
                'kd_katkeg' => $request->kd_katkeg,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'status' => $status
            ]);

            if (!$kegiatan) {
                throw new \Exception('Gagal menyimpan data kegiatan');
            }

            // Upload foto
            $lastFotoCode = FotoKegiatan::orderBy('kd_fotokeg', 'desc')->first();
            $fotoNumber = $lastFotoCode ? (int)substr($lastFotoCode->kd_fotokeg, 2) + 1 : 1;

            foreach ($photos as $index => $file) {
                try {
                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = storage_path('app/public/kegiatan-photos');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    if (!$file->move($destinationPath, $filename)) {
                        throw new \Exception("Gagal mengupload foto ke-" . ($index + 1));
                    }

                    $fotoCode = sprintf("FK%03d", $fotoNumber);

                    $fotoKegiatan = FotoKegiatan::create([
                        'kd_fotokeg' => $fotoCode,
                        'kd_kegiatan2' => $newCode,
                        'foto_path' => 'kegiatan-photos/' . $filename
                    ]);

                    if (!$fotoKegiatan) {
                        throw new \Exception("Gagal menyimpan data foto ke-" . ($index + 1));
                    }

                    $fotoNumber++;
                } catch (\Exception $e) {
                    if (isset($filename) && file_exists($destinationPath . '/' . $filename)) {
                        unlink($destinationPath . '/' . $filename);
                    }
                    throw $e;
                }
            }

            DB::commit();
            return redirect()->route('kelolaKegiatan2.index')
                ->with('success', 'Kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function addPhotos(Request $request)
    {
        try {
            // Validasi input
            if (!$request->hasFile('photos')) {
                return back()->with('error', 'Pilih foto terlebih dahulu');
            }

            $photos = $request->file('photos');
            if (!is_array($photos) || count($photos) === 0) {
                return back()->with('error', 'Tidak ada file yang diunggah.');
            }

            $kegiatan = kegitanKomunitas::with('fotoKegiatan')->find($request->kd_kegiatan2);
            if (!$kegiatan) {
                return back()->with('error', 'Kegiatan tidak ditemukan');
            }

            // Validasi jumlah foto
            $currentPhotoCount = $kegiatan->fotoKegiatan->count();
            $newPhotoCount = count($photos);

            if (($currentPhotoCount + $newPhotoCount) > 10) {
                return back()->with('error', 'Total foto tidak boleh melebihi 10. Saat ini ada ' . $currentPhotoCount . ' foto.');
            }

            // Validasi dan proses setiap foto
            $totalSize = 0;
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            foreach ($photos as $index => $photo) {
                // Pastikan file tidak null
                if (!$photo || !$photo->isValid()) {
                    return back()->with('error', 'Foto ke-' . ($index + 1) . ' tidak valid atau gagal diunggah.');
                }

                // Validasi format
                if (!in_array(strtolower($photo->getClientOriginalExtension()), $allowedExtensions)) {
                    return back()->with('error', 'Foto ke-' . ($index + 1) . ' harus berformat JPG, JPEG, atau PNG');
                }

                // Validasi ukuran per file (5MB)
                if ($photo->getSize() > (5 * 1024 * 1024)) {
                    return back()->with('error', 'Foto ke-' . ($index + 1) . ' melebihi batas ukuran 5MB');
                }

                $totalSize += $photo->getSize();
            }

            // Validasi total ukuran (20MB)
            if ($totalSize > (20 * 1024 * 1024)) {
                return back()->with('error', 'Total ukuran foto melebihi 20MB. Ukuran total saat ini: ' . number_format($totalSize / (1024 * 1024), 2) . 'MB');
            }

            // Proses upload dan simpan ke database
            $lastFotoCode = FotoKegiatan::orderBy('kd_fotokeg', 'desc')->first();
            $fotoNumber = $lastFotoCode ? (int)substr($lastFotoCode->kd_fotokeg, 2) + 1 : 1;
            // $destinationPath = 'public/kegiatan-photos';

            foreach ($photos as $index => $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = storage_path('app/public/kegiatan-photos');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $kegiatan = kegitanKomunitas::with('fotoKegiatan')->find($request->kd_kegiatan2);
                if (!$kegiatan) {
                    return back()->with('error', 'Kegiatan tidak ditemukan');
                }

                if (!$file->move($destinationPath, $filename)) {
                    throw new \Exception("Gagal mengupload foto ke-" . ($index + 1));
                }

                $fotoCode = sprintf("FK%03d", $fotoNumber);

                $fotoKegiatan = FotoKegiatan::create([
                    'kd_fotokeg' => $fotoCode,
                    'kd_kegiatan2' => $request->kd_kegiatan2,
                    'foto_path' => 'kegiatan-photos/' . $filename
                ]);

                if (!$fotoKegiatan) {
                    throw new \Exception("Gagal menyimpan data foto ke-" . ($index + 1));
                }

                $fotoNumber++;
            }

            return back()->with('success', 'Foto berhasil ditambahkan');
        } catch (\Exception $e) {
            // \Log::error('Error adding photos', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deletePhoto($kdFoto)
    {
        try {
            $foto = FotoKegiatan::findOrFail($kdFoto);
            Storage::delete('public/' . $foto->foto_path);
            $foto->delete();

            return back()->with('success', 'Foto berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($kdKegiatan)
    {
        try {
            $kegiatan = kegitanKomunitas::with('fotoKegiatan')->findOrFail($kdKegiatan);

            // Delete associated photos
            foreach ($kegiatan->fotoKegiatan as $foto) {
                Storage::delete('public/' . $foto->foto_path);
                $foto->delete();
            }

            $kegiatan->delete();
            return redirect()->route('kelolaKegiatan2.index')->with('success', 'Kegiatan berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getEnumValues($table, $column)
    {
        $type = DB::select("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND COLUMN_NAME = ?", [$table, $column])[0]->COLUMN_TYPE;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        return str_getcsv($matches[1], ',', "'");
    }
}
