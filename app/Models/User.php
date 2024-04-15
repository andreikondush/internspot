<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property int $role_id
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'password' => 'hashed',
    ];

    /**
     * Internships
     *
     * @return HasMany
     */
    public function internships(): HasMany
    {
        return $this->hasMany(Feedback::class, 'user_id', 'id');
    }

    /**
     * Role
     *
     * @return ?Role
     */
    public function role(): ?Role
    {
        /** @var ?Role */
        return $this->hasOne(Role::class, 'id', 'user_id')->first();
    }

    /**
     * Is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        $role = $this->role();

        if ($role instanceof Role) {
            return $role->name === 'admin';
        }

        return false;
    }
}
