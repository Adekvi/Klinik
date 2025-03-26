<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isApoteker
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
        if (auth()->check() && auth()->user()->role === 'apoteker') {
            return $next($request);
        }
        // session()->flash('error', 'Tidak bisa dibuka. Anda tidak memiliki akses');
        // return redirect('login/index');
        return redirect()->route('/');
    }
}
