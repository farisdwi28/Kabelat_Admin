<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;

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
}
