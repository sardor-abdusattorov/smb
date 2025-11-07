<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // login route yo‘q — mehmonni home’ga qaytaramiz
        if (! $request->expectsJson()) {
            return route('home'); // yoki: return '/';
        }
        return null; // AJAX/API uchun 401
    }
}
