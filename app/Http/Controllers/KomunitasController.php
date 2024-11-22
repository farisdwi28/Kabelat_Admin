<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komunitas;

class KomunitasController extends Controller
{
    public function index() {
        try {
            $Komunitas = Komunitas::with('Ketua') -> get();
            // dd($Komunitas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        return view('tables.basic', compact('Komunitas'));
    }
}
