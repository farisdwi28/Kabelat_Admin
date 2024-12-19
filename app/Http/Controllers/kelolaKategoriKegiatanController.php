<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoriKegiatan;

class kelolaKategoriKegiatanController extends Controller
{
    public function index()
    {
        $kategoris = kategoriKegiatan::all();
        return view('kelolaKategoriKegiatan.kelolaKategoriKegiatan', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_katkeg' => 'required',
        ]);
        
        $lastKategori = kategoriKegiatan::orderBy('kd_katkeg', 'desc')->first();
        if ($lastKategori) {
            $lastNumber = intval(substr($lastKategori->kd_katkeg, 2));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $kd_katkeg = 'KK' . $newNumber;
        } else {
            $kd_katkeg = 'KK001';
        }

        kategoriKegiatan::create([
            'kd_katkeg' => $kd_katkeg,
            'nm_katkeg' => $request->nm_katkeg,
            'ket_kat' => $request->ket_kat,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_katkeg' => 'required',
        ]);

        $kategori = kategoriKegiatan::findOrFail($id);
        $kategori->update([
            'nm_katkeg' => $request->nm_katkeg,
            'ket_kat' => $request->ket_kat,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = kategoriKegiatan::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
