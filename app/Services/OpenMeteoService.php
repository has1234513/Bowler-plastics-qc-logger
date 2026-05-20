<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenMeteoService
{
    /**
     * Fetch current temperature and humidity for the configured factory location.
     *
     * @return array{temperature_celsius: float, humidity_percent: int, logged_at: CarbonImmutable}
     */
    public function fetchCurrentConditions(): array
    {
        $config = config('services.open_meteo');

        $response = Http::timeout(5)
            ->retry(2, 200)
            ->get("{$config['base_url']}/forecast", [
                'latitude' => $config['latitude'],
                'longitude' => $config['longitude'],
                'current' => 'temperature_2m,relative_humidity_2m',
                'timezone' => $config['timezone'],
            ])
            ->throw();

        $current = $response->json('current');

        if (! isset($current['temperature_2m'], $current['relative_humidity_2m'], $current['time'])) {
            throw new RuntimeException('Open-Meteo response is missing expected fields.');
        }

        return [
            'temperature_celsius' => (float) $current['temperature_2m'],
            'humidity_percent' => (int) $current['relative_humidity_2m'],
            'logged_at' => CarbonImmutable::parse($current['time'])->shiftTimezone($config['timezone']),
        ];
    }
}
