<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Services\EventInsightsService;

class InsightsController extends Controller
{
    protected $insightsService;

    public function __construct(EventInsightsService $insightsService)
    {
        $this->insightsService = $insightsService;
    }

    public function index()
    {
        $insights = $this->insightsService->getInsights();

        return view('organizer.insights', $insights);
    }
}
