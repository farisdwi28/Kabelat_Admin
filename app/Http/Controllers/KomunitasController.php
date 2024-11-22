<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;

class KomunitasController extends Controller
{
    public function index()
    {
        try {
            $Komunitas = Komunitas::with('Ketua')->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('Komunitas.komunitas', compact('Komunitas'));
    }
    public function showMembers($kd_komunitas)
    {
        try {
            $Komunitas = Komunitas::with('Members')->findOrFail($kd_komunitas);
    
            return view('Komunitas.members', [
                'Komunitas' => $Komunitas,
                'Members' => $Komunitas->Members
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
