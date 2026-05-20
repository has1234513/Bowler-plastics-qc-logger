<?php

namespace App\Http\Controllers\QC;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnvironmentalLogRequest;
use App\Models\EnvironmentalLog;
use App\Services\OpenMeteoService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class EnvironmentalLogController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('QC/Index', [
            'logs' => EnvironmentalLog::query()
                ->orderByDesc('logged_at')
                ->get(),
        ]);
    }

    public function store(
        StoreEnvironmentalLogRequest $request,
        OpenMeteoService $weather,
    ): RedirectResponse {
        $conditions = $weather->fetchCurrentConditions();

        EnvironmentalLog::create([
            'batch_number' => $request->validated('batch_number'),
            ...$conditions,
        ]);

        return back()->with('success', 'Conditions logged successfully.');
    }
}
