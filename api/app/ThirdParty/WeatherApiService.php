<?php

namespace App\ThirdParty;

use GuzzleHttp\Client;
use App\Exceptions\WeatherApiException;

class WeatherApiService
{
    protected $apiKey;

    protected $url = 'https://api.openweathermap.org/';
    protected $weatherUri = 'data/2.5/weather?';

    protected $dateFormat = 'Y-m-d H:i:s';
    protected $tempFormat = 'metric';

    protected $config;


    public function __construct()
    {
        self::setApiKey();
    }

    protected function setApiKey()
    {
        $this->apiKey = config('services.openweather.key');
    }

    private function prepareQueryString(array $params)
    {
        $params['appid'] = $this->apiKey;
        $params['units'] = $this->tempFormat;

        return http_build_query($params);
    }

    public function fetch($route, $params = [])
    {
        $this->requestor = new Client([
            'base_uri' => $this->url,
            'timeout' => 10.0,
        ]);

        try {
            $route = $route . $this->prepareQueryString($params);
            $response = $this->requestor->request('GET', $route, [
                'curl' => [
                   CURLOPT_CONNECTTIMEOUT_MS => 500 // this is throw error if api call take more then 500ms  
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch (\Exception $e) {
            throw new WeatherApiException($e->getMessage());
        }
    }

    private function getWeather(array $query): array
    {

        $data = $this->fetch($this->weatherUri, $query);

        return $this->format($data);
    }

    public function getWeatherByCoordinate(string|float $lat, string|float $lon)
    {
        $lat  = (float) $lat;
        $lon  = (float) $lon;

        if ($lat > 90  || $lat < -90 || $lon > 180 || $lat < -180) {
            throw new \Exception("Invalid coordinate passed", 1);
            
        }

        return $this->getWeather([
            'lat' => $lat,
            'lon' => $lon,
        ]);
    }

    public function format(array $response): array
    {
        return [
          "weather" => array_map(function ($data) {
            return [
              "main"        => $data['main'] ?? '',
              "description" => $data['description'] ?? '',
              "icon"        => $data['icon'] ?? '',
            ];
          }, $response['weather']),
          "main" => [
            "temp"       => $response['main']['temp'] ?? 0,
            "feels_like" => $response['main']['feels_like'] ?? 0,
            "temp_min"   => $response['main']['temp_min'] ?? 0,
            "temp_max"   => $response['main']['temp_max'] ?? 0,
            "pressure"   => $response['main']['pressure'] ?? 0,
            "humidity"   => $response['main']['humidity'] ?? 0,
            "sea_level"  => $response['main']['sea_level'] ?? 0,
            "grnd_level" => $response['main']['grnd_level'] ?? 0,
          ],
          "visibility" => $response['visibility'] ?? 0,
          "wind" => [
            "speed" => $response['wind']['speed'] ?? 0,
            "deg"   => $response['wind']['deg'] ?? 0,
            "gust"  => $response['wind']['gust'] ?? 0,
          ],
          "rain" => [
            "1h" => $response['rain']['1h'] ?? null,
            "3h" => $response['rain']['3h'] ?? null,
          ],
          "snow" => [
            "1h" => $response['snow']['1h'] ?? null,
            "3h" => $response['snow']['3h'] ?? null,
          ],
          "clouds" => [
            "all"  => $response['clouds']['all'] ?? 0,
          ],
          "dt"     => isset($response['dt']) ? date($this->dateFormat, $response['dt']) : null,
          "sys" => [
            "country" => $response['sys']['country'] ?? '',
            "sunrise" => isset($response['sys']['sunrise']) ? date($this->dateFormat, $response['sys']['sunrise']) : null,
            "sunset"  => isset($response['sys']['sunset']) ? date($this->dateFormat, $response['sys']['sunset']) : null,
          ],
          "timezone" => $response['timezone'] ?? 0,
          "name" => $response['name'] ?? 0,
        ];
    }
}
