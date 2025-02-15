<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('authorization');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ( in_array('user', $guards, true) ) {
            if ( !auth('user')->check() ) {
                return redirect()->route('authorization');
            }
        }

        return $next($request);
    }
}
