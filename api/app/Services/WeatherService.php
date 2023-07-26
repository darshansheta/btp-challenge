<?php

namespace App\Services;

use App\Models\Weather;
use App\Models\User;
use App\Events\WeatherUpdated;

class WeatherService
{
    public function saveWeatherDataFromApi(User $user, array $apiData): void
    {
        $data = [
            "weather_array"   => $apiData['weather'],
            "main"            => $apiData['weather'][0]['main'] ?? null,
            "description"     => $apiData['weather'][0]['description'] ?? null,
            "icon"            => $apiData['weather'][0]['icon'] ?? null,

            "main_temp"       => $apiData['main']['temp'],
            "main_feels_like" => $apiData['main']['feels_like'],
            "main_temp_min"   => $apiData['main']['temp_min'],
            "main_temp_max"   => $apiData['main']['temp_max'],
            "main_pressure"   => $apiData['main']['pressure'],
            "main_humidity"   => $apiData['main']['humidity'],
            "main_sea_level"  => $apiData['main']['sea_level'],
            "main_grnd_level" => $apiData['main']['grnd_level'],

            "visibility"      => $apiData['visibility'],

            "wind_speed"      => $apiData['wind']['speed'],
            "wind_deg"        => $apiData['wind']['deg'],
            "wind_gust"       => $apiData['wind']['gust'],


            "rain_1h"         => $apiData['rain']['1h'],
            "rain_3h"         => $apiData['rain']['3h'],

            "snow_1h"         => $apiData['snow']['1h'],
            "snow_3h"         => $apiData['snow']['3h'],

            
            "clouds_all"      => $apiData['clouds']['all'],
            
            "calculated_at"   => $apiData['dt'],
            "timezone_offset" => $apiData['timezone'],

            "sys_country"     => $apiData['sys']['country'],
            "sys_sunrise"     => $apiData['sys']['sunrise'],
            "sys_sunset"      => $apiData['sys']['sunset'],
            "city_name"       => $apiData['name'],
        ];

        $this->saveWeatherData($user, $data);
    }

    public function saveWeatherData(User $user, array $data): void
    {
        $weather = Weather::firstOrCreate(['user_id' => $user->id]);
        $weather->update($data);

        WeatherUpdated::dispatch($user);
    }
}
