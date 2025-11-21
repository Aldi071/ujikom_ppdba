<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class LogActivityMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Pass the request down the middleware stack
        $response = $next($request);

        // Log aktivitas untuk certain routes
        if (Auth::check() && $this->shouldLog($request)) {
            $this->recordActivity($request);
        }

        return $response;
    }

    /**
     * Determine if the request should be logged
     */
    private function shouldLog(Request $request)
    {
        // Log untuk routes tertentu
        $loggableRoutes = [
            'admin.master.*',
            'admin.laporan.*',
            'admin.akun.*',
            'verifikator.*',
            'keuangan.*',
            'kepsek.*'
        ];

        foreach ($loggableRoutes as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Record the activity
     */
    private function recordActivity(Request $request)
    {
        try {
            $method = $request->method();
            $path = $request->path();
            $action = 'VIEW'; // Default action

            // Determine action based on HTTP method
            if ($method === 'POST') {
                $action = 'CREATE';
            } elseif ($method === 'PUT' || $method === 'PATCH') {
                $action = 'UPDATE';
            } elseif ($method === 'DELETE') {
                $action = 'DELETE';
            }

            // Get the route name
            $routeName = $request->route()?->getName() ?? $path;

            LogAktivitas::create([
                'user_id' => Auth::user()->id,
                'aksi' => $action,
                'objek' => $routeName,
                'waktu' => now(),
                'ip' => $request->ip()
            ]);
        } catch (\Exception $e) {
            // Silently fail - don't break the app if logging fails
        }
    }
}
