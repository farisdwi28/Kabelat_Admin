<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;
use App\Models\strukturKomunitas;

class kelolaStrukturController extends Controller
{
    public function index()
    {
        try {
            $Komunitas = Komunitas::get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('kelolaStruktur.kelolaStruktur', compact('Komunitas'));
    }

    public function showDetail($id)
    {
        try {
            $komunitas = Komunitas::findOrFail($id);
            return view('kelolaStruktur.detailStruktur', compact('komunitas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data komunitas.');
        }
    }

    public function edit($id)
    {
        $komunitas = Komunitas::findOrFail($id);
        $jabatan = strukturKomunitas::all();
        return view('kelolaStruktur.editStruktur', compact('komunitas', 'jabatan'));
    }

    public function update(Request $request, $id)
    {
        $komunitas = Komunitas::findOrFail($id);
        $komunitas->jabatan()->sync($request->jabatan);
        return redirect()->back()->with('success', 'Struktur jabatan berhasil diperbarui.');
    }

    public function removeJabatan($id, $jabatan_id)
    {
        $komunitas = Komunitas::findOrFail($id);
        $komunitas->jabatan()->detach($jabatan_id);
        return redirect()->back()->with('success', 'Jabatan berhasil dihapus.');
    }
}
