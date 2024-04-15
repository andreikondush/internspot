<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Internship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'address',
        'city_id',
        'company_id',
        'user_id'
    ];

    /**
     * City
     *
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    /**
     * Company
     *
     * @return HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    /**
     * User
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Tags
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'internship_tags');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'internship_id', 'id');
    }
}
