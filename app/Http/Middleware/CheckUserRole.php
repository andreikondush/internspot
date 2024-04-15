<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Create role admin
        if ( !Role::where('name', 'admin')->exists() ) {
            Role::create(['name' => 'admin']);
        }

        // Create role student
        if ( !Role::where('name', 'student')->exists() ) {
            Role::create(['name' => 'student']);
        }

        return $next($request);
    }
}
