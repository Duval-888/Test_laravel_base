<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsModerator
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'moderator'])) {
            abort(403, 'Accès réservé aux modérateurs.');
        }

        return $next($request);
    }
}