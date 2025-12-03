<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdleLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        // Ambil timestamp aktivitas terakhir
        $lastActivity = session('last_activity');
        $now = now()->timestamp;

        // Konversi session lifetime dari menit → detik
        $idleLimit = config('session.lifetime') * 60;

        // Jika sudah pernah ada last_activity dan selisihnya melebihi batas → logout
        if ($lastActivity && ($now - $lastActivity) > $idleLimit) {

            Auth::logout();
            session()->invalidate();  // lebih aman daripada flush()
            session()->regenerateToken();

            return redirect()->route('login')
                ->with('message', 'Session expired otomatis karena idle.');
        }

        // Jika belum idle → perbarui waktu aktivitas
        session(['last_activity' => $now]);

        return $next($request);
    }
}
