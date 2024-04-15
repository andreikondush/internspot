<?php

namespace App\Http\View\Composers;

use App\Models\Role;
use Illuminate\Auth\GenericUser;
use Illuminate\View\View;

class ViewComposer
{
    private bool $isAdmin;

    /**
     * Create a new ViewComposer instance.
     */
    public function __construct()
    {
        $this->isAdmin = $this->isAdmin();
    }

    public function compose(View $view): View
    {
        return $view->with([
            'isAdmin' => $this->isAdmin,
        ]);
    }

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
