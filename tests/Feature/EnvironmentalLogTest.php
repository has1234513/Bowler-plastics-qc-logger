<?php

use App\Models\EnvironmentalLog;
use Illuminate\Support\Facades\Http;

test('a valid batch number logs the current environmental conditions', function () {
    Http::preventStrayRequests();
    Http::fake([
        'api.open-meteo.com/*' => Http::response([
            'current' => [
                'time' => '2024-03-15T14:00',
                'interval' => 900,
                'temperature_2m' => 24.3,
                'relative_humidity_2m' => 62,
            ],
            'current_units' => [
                'temperature_2m' => '°C',
                'relative_humidity_2m' => '%',
            ],
        ]),
    ]);

    $response = $this
        ->from(route('qc.index'))
        ->post(route('qc.store'), [
            'batch_number' => 'BATCH-9942',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('qc.index'));

    $log = EnvironmentalLog::query()->sole();

    expect($log->batch_number)->toBe('BATCH-9942')
        ->and((float) $log->temperature_celsius)->toBe(24.3)
        ->and($log->humidity_percent)->toBe(62)
        ->and($log->logged_at->setTimezone('Africa/Johannesburg')->format('Y-m-d H:i'))
        ->toBe('2024-03-15 14:00');

    Http::assertSent(function ($request) {
        return str_starts_with($request->url(), 'https://api.open-meteo.com/v1/forecast')
            && (float) $request['latitude'] === -26.2041
            && (float) $request['longitude'] === 28.0473
            && $request['timezone'] === 'Africa/Johannesburg';
    });
});

test('duplicate batch numbers are rejected and the api is not called', function () {
    EnvironmentalLog::create([
        'batch_number' => 'BATCH-9942',
        'temperature_celsius' => 20.0,
        'humidity_percent' => 50,
        'logged_at' => now(),
    ]);

    Http::preventStrayRequests();

    $response = $this
        ->from(route('qc.index'))
        ->post(route('qc.store'), [
            'batch_number' => 'BATCH-9942',
        ]);

    $response
        ->assertSessionHasErrors('batch_number')
        ->assertRedirect(route('qc.index'));

    expect(EnvironmentalLog::count())->toBe(1);
});