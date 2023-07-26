<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use App\Http\Resources\UserListResource;
use App\Http\Resources\WeatherResource;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct(
        public UserService $userService,
    ) {}

    public function index(): UserListResource
    {
        $result = $this->userService->get(request()->query('perPage', 5));

        return new UserListResource($result);
    }

    public function weather(User $user): WeatherResource
    {
        return new WeatherResource(
            $this->userService->getUserWeather($user)
        );
    }


}
