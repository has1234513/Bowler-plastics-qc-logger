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
        return Inertia::render('qc/index', [
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

        $log = EnvironmentalLog::create([
            'batch_number' => $request->validated('batch_number'),
            ...$conditions,
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => "Conditions logged for batch {$log->batch_number}.",
        ]);

        return back();
    }
}
