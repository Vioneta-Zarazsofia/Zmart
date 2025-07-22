<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->is_admin == 1) {
            return $next($request);
        }

        Auth::guard('admin')->logout();
        return redirect('/admin')->with('error', 'Silakan login sebagai admin.');
    }
}
