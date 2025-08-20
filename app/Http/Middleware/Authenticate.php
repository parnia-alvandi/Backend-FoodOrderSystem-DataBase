<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     * This uses session('user') set by our AuthController to authorize.
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }

        return $next($request);
    }
}
