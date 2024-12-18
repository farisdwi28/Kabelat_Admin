<?php

namespace App\Http\Controllers;

use App\Models\Inisiator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class programDispusipController extends Controller
{
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

    private function generateInisiatorCode()
    {
        try {
            do {
                $inisiatorCode = 'I' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            } while (Inisiator::where('kd_inisiator', $inisiatorCode)->exists());

            return $inisiatorCode;
        } catch (\Exception $e) {
            Log::error('Gagal generate kode inisiator: ' . $e->getMessage());
            throw new \Exception('Gagal generate kode inisiator: ' . $e->getMessage());
        }
    }

    private function generateProgramCode()
    {
        try {
            $latestProgram = Inisiator::orderBy('kd_program', 'desc')->first();

            if (!$latestProgram) {
                return 'K0001';
            }

            $lastNumber = intval(substr($latestProgram->kd_program, 1));
            $newNumber = $lastNumber + 1;

            return 'K' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate kode komunitas: ' . $e->getMessage());
        }
    }

    public function index()
    {
        try {
            $programs = Program::with('inisiator')->get();
            // dd($programs, Inisiator::with('program')->get());
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('programDispusip.programDispusip', compact('programs'));
    }

    public function updateProgramStatus($id, $status)
    {
        try {
            $allowedStatuses = ['aktif', 'nonaktif'];

            if (!in_array($status, $allowedStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid. Gunakan "aktif" atau "nonaktif".'
                ], 400);
            }

            $program = Program::findOrFail($id);
            $program->status_program = $status;
            $program->save();

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
        return view('programDispusip.tambahProgram');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_program' => 'required|unique:program,nm_program|max:50',
            'nm_inisiator' => 'required|array|min:1',
            'nm_inisiator.*' => 'required|string|max:50',
            'tentang_program' => 'required',
            'tujuan_program' => 'required',
            'foto' => 'required|image|max:5120|mimes:jpeg,png,jpg,gif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Generate Program Code
            $programCode = $this->generateProgramCode();

            // Convert Image to Base64
            $sampulProgram = $this->convertImageToBase64($request->file('foto'));

            $program = new Program();
            $program->kd_program = $programCode;
            $program->nm_program = $request->nm_program;
            $program->tanggal_dibuat = now()->toDateString();
            $program->status_program = 'nonaktif';
            $program->tentang_program = $request->tentang_program;
            $program->tujuan_program = $request->tujuan_program;
            $program->sampul_program = $sampulProgram;
            $program->save();

            // Create Inisiators
            $inisiators = [];
            foreach ($request->nm_inisiator as $inisiatorName) {
                $inisiatorCode = $this->generateInisiatorCode();
                $inisiators[] = [
                    'kd_inisiator' => $inisiatorCode,
                    'kd_program' => $programCode,
                    'nm_inisiator' => $inisiatorName,
                ];
            }
            Inisiator::insert($inisiators);

            DB::commit();

            return redirect()->route('programDispusip')->with('success', 'Program berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan program: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan program: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $inisiators = Inisiator::where('kd_program', $id)->get();
        return view('programDispusip.editProgram', compact('program', 'inisiators'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nm_program' => 'required|max:50|unique:program,nm_program,' . $id . ',kd_program',
            'nm_inisiator' => 'required|array|min:1',
            'nm_inisiator.*' => 'required|string|max:50',
            'tentang_program' => 'required',
            'tujuan_program' => 'required',
            'foto' => 'sometimes|image|max:5120'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Cari data program
            $program = Program::findOrFail($id);
            $program->nm_program = $request->nm_program;
            $program->tentang_program = $request->tentang_program;
            $program->tujuan_program = $request->tujuan_program;

            // Update gambar jika ada file baru
            if ($request->hasFile('foto')) {
                $sampulProgram = $this->convertImageToBase64($request->file('foto'));
                $program->sampul_program = $sampulProgram;
            }

            $program->save();

            // Update daftar inisiator
            Inisiator::where('kd_program', $id)->delete(); // Hapus inisiator lama

            $inisiators = [];
            foreach ($request->nm_inisiator as $inisiatorName) {
                $inisiatorCode = $this->generateInisiatorCode();
                $inisiators[] = [
                    'kd_inisiator' => $inisiatorCode,
                    'kd_program' => $id,
                    'nm_inisiator' => $inisiatorName
                ];
            }
            Inisiator::insert($inisiators);

            DB::commit();

            return redirect()->route('programDispusip')->with('success', 'Program berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat memperbarui program: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui program: ' . $e->getMessage());
        }
    }

    // public function destroy($id)
    // {
    //     try {
    //         $program = Program::findOrFail($id);
    //         $program->delete();

    //         return redirect()->route('program.index')->with('success', 'Program berhasil dihapus');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }
}
