<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function weather(): HasOne
    {
        return $this->hasOne(Weather::class);
    }

    // get All users who aren't updated in last hour

    // We can use only one table `weathers` but in case if there are new users
    // then in that case there might be no record in `weather` table, so to fatch
    // those new users we join and added appropriate where clause
    public static function getUpdatableWeatherUsers(int $limit = 5): Collection
    {
        return self::query()
            ->leftJoin('weathers', 'weathers.user_id', '=', 'users.id')
            ->whereRaw('weathers.updated_at <= DATE_SUB(NOW(),INTERVAL 1 HOUR)')
            ->orWhereNull('weathers.updated_at')
            ->orderBy('weathers.updated_at')
            ->select('users.*')
            ->limit($limit)
            ->get();
    }
}
