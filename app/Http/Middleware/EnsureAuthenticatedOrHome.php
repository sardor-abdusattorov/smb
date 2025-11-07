<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureAuthenticatedOrHome
{
    public function handle($request, Closure $next, $guard = 'web')
    {
        if (! Auth::guard($guard)->check()) {
            return redirect()->route('home'); // yoki '/'
        }
        return $next($request);
    }
}
