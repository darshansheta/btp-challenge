<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // we also can use PHP's optional chaining like - $this->weather? but this will be DRY principal 
        $weather = optional($this->weather);

        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'location' => [
                'city'    => $weather->city_name,
                'country' => $weather->sys_country,
            ],
            'weather'  => [
                'title'       => $weather->main,
                'description' => $weather->description,
                'icon'        => $weather->icon,
                'clouds'      => $weather->clouds_all, 
            ],
            'temprature' => [
                'actual'    =>  $weather->main_temp,
                'feelsLike' =>  $weather->main_feels_like,
            ],
            'climate' => [
                'pressure'    => $weather->main_pressure,
                'humidity'    => $weather->main_humidity,
                'seaLevel'    => $weather->main_sea_level,
                'groundLevel' => $weather->main_grnd_level,
            ],
            'wind' => [
                'speed'     => $weather->wind_speed,
                'direction' => $weather->wind_deg,
            ],
            'rain' => [
                'rain1h' => $weather->rain_1h,
                'rain3h' => $weather->rain_3h,
            ],
            'snow' => [
                'snow1h' => $weather->snow_1h,
                'snow3h' => $weather->snow_3h,
            ],
            'updatedAt'    => $weather->updated_at->diffForHumans(),
            'calculatedAt' => $weather->updated_at->diffForHumans(),
        ];
    }
}
