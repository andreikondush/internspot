<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
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
        if (auth('user')->check()) {
            $user = auth('user')->user();
            if ($user instanceof GenericUser) {
                $role = Role::whereId($user->role_id)->first();
                if ($role instanceof Role) {
                    if ($role->name === 'admin') {
                        return $next($request);
                    }
                }
            }
        }

        return redirect()->route('home');
    }
}
