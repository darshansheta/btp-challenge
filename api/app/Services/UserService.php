<?php

namespace App\Services;

use App\Models\Weather;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function get($perPage = 5): LengthAwarePaginator
    {
        return User::query()
                ->leftJoin('weathers', 'weathers.user_id', '=', 'users.id')
                ->orderBy('weathers.updated_at')
                ->paginate($perPage,[
                    'users.*',
                    'weathers.main_temp',
                    'weathers.main_feels_like',
                    'weathers.main',
                    'weathers.description',
                    'weathers.icon'
                ]);
    }

    public function getUserWeather(User $user): User
    {
        $user->load('weather');

        return $user;
    }
}
