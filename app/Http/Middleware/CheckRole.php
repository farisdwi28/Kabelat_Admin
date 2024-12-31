<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Jika user memiliki role yang sesuai, izinkan akses
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect ke dashboard yang sesuai berdasarkan role
        if ($user->role === 'superAdmin') {
            return redirect('/dashboard');
        }
        
        if ($user->role === 'adminLokal') {
            return redirect('/dashboardLokal');
        }

        return redirect('/login');
    }
}