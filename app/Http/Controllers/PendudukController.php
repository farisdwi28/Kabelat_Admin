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

    public function importCsv()
    {
        return view('user.importCsv');
    }

    public function storeCsv(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            ]);

            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            
            $data = array_map('str_getcsv', file($path));
            $header = array_shift($data); // Remove header row
            
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Map CSV columns to database fields
                    $pendudukData = array_combine($header, $row);
                    
                    // Validate required fields
                    $requiredFields = ['nm_pen', 'jk', 'no_ktp', 'tgl_lahir', 'tempat_lahir', 'alamat', 'no_hp', 'RT', 'RW', 'desa', 'kecamatan'];
                    foreach ($requiredFields as $field) {
                        if (empty($pendudukData[$field])) {
                            throw new \Exception("Field {$field} is required on row " . ($index + 2));
                        }
                    }

                    // Validate KTP format
                    if (!preg_match('/^\d{16}$/', $pendudukData['no_ktp'])) {
                        throw new \Exception("Invalid KTP format on row " . ($index + 2));
                    }

                    // Check if KTP already exists
                    if (Penduduk::where('no_ktp', $pendudukData['no_ktp'])->exists()) {
                        throw new \Exception("KTP already exists on row " . ($index + 2));
                    }

                    // Validate gender
                    if (!in_array($pendudukData['jk'], ['Laki-laki', 'Perempuan'])) {
                        throw new \Exception("Invalid gender value on row " . ($index + 2));
                    }

                    // Validate date format
                    if (!strtotime($pendudukData['tgl_lahir'])) {
                        throw new \Exception("Invalid date format on row " . ($index + 2));
                    }

                    // Validate RT/RW
                    if (!is_numeric($pendudukData['RT']) || !is_numeric($pendudukData['RW'])) {
                        throw new \Exception("RT/RW must be numeric on row " . ($index + 2));
                    }

                    // Create new penduduk record
                    $penduduk = new Penduduk();
                    $penduduk->kd_pen = $this->generateKodePenduduk();
                    $penduduk->nm_pen = $pendudukData['nm_pen'];
                    $penduduk->jk = $pendudukData['jk'];
                    $penduduk->tgl_lahir = $pendudukData['tgl_lahir'];
                    $penduduk->tempat_lahir = $pendudukData['tempat_lahir'];
                    $penduduk->alamat = $pendudukData['alamat'];
                    $penduduk->no_ktp = $pendudukData['no_ktp'];
                    $penduduk->no_hp = $pendudukData['no_hp'];
                    $penduduk->RT = (int)$pendudukData['RT'];
                    $penduduk->RW = (int)$pendudukData['RW'];
                    $penduduk->desa = $pendudukData['desa'];
                    $penduduk->kecamatan = $pendudukData['kecamatan'];
                    
                    // Set default photo if not provided
                    $penduduk->foto_pen = $pendudukData['foto_pen'] ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

                    $penduduk->save();
                    $successCount++;

                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $message = "Import completed. Success: {$successCount}, Errors: {$errorCount}";
            
            if ($errorCount > 0) {
                return redirect()
                    ->route('penduduk')
                    ->with('swal_error', [
                        'title' => 'Import Completed with Errors',
                        'text' => $message . '. Check the following errors: ' . implode('; ', array_slice($errors, 0, 5)),
                        'icon' => 'warning'
                    ]);
            }

            return redirect()
                ->route('penduduk')
                ->with('swal_success', [
                    'title' => 'Import Successful!',
                    'text' => $message,
                    'icon' => 'success'
                ]);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('swal_error', [
                    'title' => 'Import Failed',
                    'text' => 'Error: ' . $e->getMessage(),
                    'icon' => 'error'
                ]);
        }
    }

    public function downloadCsvTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_penduduk.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'nm_pen',
                'jk', 
                'no_ktp',
                'tgl_lahir',
                'tempat_lahir',
                'alamat',
                'no_hp',
                'RT',
                'RW',
                'desa',
                'kecamatan'
            ]);
            
            // Example data row
            fputcsv($file, [
                'Ahmad Fahri',
                'Laki-laki',
                '1234567890123456',
                '1990-01-01',
                'Bandung',
                'Jl. Raya Cimareme No.123, Cimareme, Kec. Ngamprah, Kabupaten Bandung, Jawa Barat',
                '081234567890',
                '001',
                '002',
                'Cimareme',
                'Ngamprah'
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nm_pen' => 'required|string|max:255',
                'jk' => 'required|in:Laki-laki,Perempuan',
                'no_ktp' => 'required|string|size:16|unique:penduduk,no_ktp',
                'tgl_lahir' => 'required|date',
                'tempat_lahir' => 'required|string|max:255',
                'alamat' => 'required|string|max:1000',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'no_hp' => 'required|string|max:20',
                'RT' => 'required|integer|min:1|max:999',
                'RW' => 'required|integer|min:1|max:999',
                'desa' => 'required|string|max:50',
                'kecamatan' => 'required|string|max:50'
            ]);

            $penduduk = new Penduduk();
            $penduduk->kd_pen = $this->generateKodePenduduk();
            $penduduk->nm_pen = $validated['nm_pen'];
            $penduduk->jk = $validated['jk'];
            $penduduk->tgl_lahir = $validated['tgl_lahir'];
            $penduduk->tempat_lahir = $validated['tempat_lahir'];
            $penduduk->alamat = $validated['alamat'];
            $penduduk->no_ktp = $validated['no_ktp'];
            $penduduk->no_hp = $validated['no_hp'];
            $penduduk->RT = $validated['RT'];
            $penduduk->RW = $validated['RW'];
            $penduduk->desa = $validated['desa'];
            $penduduk->kecamatan = $validated['kecamatan'];

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $base64Image = $this->convertImageToBase64($image);
                $penduduk->foto_pen = $base64Image;
            }

            $penduduk->save();

            return redirect()
                ->route('penduduk')
                ->with('swal_success', [
                    'title' => 'Berhasil!',
                    'text' => 'Data Penduduk berhasil ditambahkan',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('swal_error', [
                    'title' => 'Error',
                    'text' => 'Gagal menambahkan data: NO KTP sudah terdaftar',
                    'icon' => 'error'
                ])
                ->withInput();
        }
    }
    private function generateKodePenduduk()
    {
        try {
            $latestPenduduk = Penduduk::orderBy('kd_pen', 'desc')->first();

            if (!$latestPenduduk) {
                return 'P0001';
            }

            $lastNumber = intval(substr($latestPenduduk->kd_pen, 1));
            $newNumber = $lastNumber + 1;

            return 'P' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
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
            $request->validate([
                'nm_pen' => 'required|string|max:255',
                'jk' => 'required|in:Laki-laki,Perempuan',
                'tgl_lahir' => 'required|date',
                'tempat_lahir' => 'required|string|max:255',
                'alamat' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'no_ktp' => 'required|string|size:16|unique:penduduk,no_ktp,' . $kd_pen . ',kd_pen',
                'no_hp' => 'required|string|max:20',
                'RT' => 'required|integer|min:1|max:999',
                'RW' => 'required|integer|min:1|max:999',
                'desa' => 'required|string|max:50',
                'kecamatan' => 'required|string|max:50'
            ]);

            $Penduduk = Penduduk::findOrFail($kd_pen);

            $Penduduk->nm_pen = $request->nm_pen;
            $Penduduk->jk = $request->jk;
            $Penduduk->tgl_lahir = $request->tgl_lahir;
            $Penduduk->tempat_lahir = $request->tempat_lahir;
            $Penduduk->alamat = $request->alamat;
            $Penduduk->no_ktp = $request->no_ktp;
            $Penduduk->no_hp = $request->no_hp;
            $Penduduk->RT = $request->RT;
            $Penduduk->RW = $request->RW;
            $Penduduk->desa = $request->desa;
            $Penduduk->kecamatan = $request->kecamatan;

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $base64Image = $this->convertImageToBase64($image);
                $Penduduk->foto_pen = $base64Image;
            }

            $Penduduk->save();

            return redirect()
                ->route('penduduk')
                ->with('swal_success', [
                    'title' => 'Berhasil!',
                    'text' => 'Data Penduduk berhasil diperbarui',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('swal_error', [
                    'title' => 'Error',
                    'text' => 'Gagal memperbarui data: ' . $e->getMessage(),
                    'icon' => 'error'
                ])
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
            return redirect()
                ->route('penduduk')
                ->with('swal_success', [
                    'title' => 'Berhasil!',
                    'text' => 'Data Penduduk berhasil dihapus',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('penduduk')
                ->with('swal_error', [
                    'title' => 'Error',
                    'text' => 'Gagal menghapus data: ' . $e->getMessage(),
                    'icon' => 'error'
                ]);
        }
    }
}
