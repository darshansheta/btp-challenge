<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\ThirdParty\WeatherApiService;
use App\Services\WeatherService;

class UpdateUserWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(WeatherApiService $weatherApiService, WeatherService $weatherService): void
    {
        $weatherData = $weatherApiService->getWeatherByCoordinate($this->user->latitude, $this->user->longitude);

        $weatherService->saveWeatherDataFromApi($this->user, $weatherData);
    }


}
