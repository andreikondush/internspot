<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Auth\GenericUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        if (auth('user')->check()) {
            $user = auth('user')->user();
            if ($user instanceof GenericUser) {
                $role = Role::whereId($user->role_id)->first();
                if ($role instanceof Role) {
                    return $role->name === 'admin';
                }
            }
        }

        return false;
    }
}
