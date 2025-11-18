<?php

namespace App\Http\Controllers;

use App\Services\InventoryAnalyticsService;

class AnalyticsController extends Controller
{
    protected $analytics;

    public function __construct(InventoryAnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    // Predict future demand
    public function predictTool($toolId)
    {
        $result = $this->analytics->predictFutureDemand($toolId);
        return response()->json($result);
    }

    // Recommend stock / reorder amount
    public function recommendTool($toolId)
    {
        $result = $this->analytics->suggestReorder($toolId);
        return response()->json($result);
    }

    // Detect anomalies in usage
    public function anomalyCheck($toolId)
    {
        $result = $this->analytics->detectAnomalies($toolId);
        return response()->json($result);
    }

    // Full combined analytics
    public function fullReport($toolId)
    {
        $result = $this->analytics->generateFullReport($toolId);
        return response()->json($result);
    }
}
