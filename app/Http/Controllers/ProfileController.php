<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        DB::table('users')
            ->where('id', Auth::id())
            ->update(['name' => $request->name]);

        return response()->json([
            'message' => 'Name updated successfully'
        ]);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id()
        ]);

        DB::table('users')
            ->where('id', Auth::id())
            ->update(['email' => $request->email]);

        return response()->json([
            'message' => 'Email updated successfully'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password'
        ]);

        $currentPasswordCheck = DB::table('users')
            ->where('id', $user->id)
            ->first();

        if (!Hash::check($request->current_password, $currentPasswordCheck->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect']
            ]);
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
}