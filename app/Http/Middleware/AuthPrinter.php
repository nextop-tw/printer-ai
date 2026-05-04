<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPrinter
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('printer')->check()) {
            return redirect()->route('printer.login');
        }
        return $next($request);
    }
}
