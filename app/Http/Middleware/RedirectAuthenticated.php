<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                // Redirect berdasarkan role
                switch($user->role) {
                    case 'admin':
                    case 'verifikator_adm':
                    case 'keuangan':
                    case 'kepsek':
                        return redirect('/admin/dashboard');
                    case 'pendaftar':
                        return redirect('/');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}