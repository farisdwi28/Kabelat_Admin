<?php

namespace App\Http\Controllers;

use App\Models\Inisiator;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class programDispusipController extends Controller
{
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
}
