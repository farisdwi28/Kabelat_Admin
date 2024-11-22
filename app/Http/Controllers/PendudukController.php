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
}
