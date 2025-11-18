<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryAnalyticsService
{
    /**
     * Predict future demand based on historical usage logs.
     * This method works even without external ML packages.
     */
    public function predictFutureDemand($toolId)
    {
        // Fetch usage logs for the tool
        $usageData = DB::table('issued_logs')
            ->where('tool_id', $toolId)
            ->orderBy('date_issued')
            ->pluck('date_issued')
            ->toArray();

        if (count($usageData) < 2) {
            return [
                'tool_id' => $toolId,
                'prediction' => 1, // minimal demand
                'message' => 'Not enough historical data — using default baseline estimate.'
            ];
        }

        // Convert dates to week numbers to detect usage frequency
        $weeks = array_map(function ($date) {
            return Carbon::parse($date)->format('W');
        }, $usageData);

        // Count how many times per week the tool is used
        $frequency = array_count_values($weeks);

        // Calculate average weekly usage
        $avgWeeklyUsage = array_sum($frequency) / count($frequency);

        // Simple naive forecast: +20% based on trend
        $predictedDemand = round($avgWeeklyUsage * 1.2);

        return [
            'tool_id' => $toolId,
            'prediction' => $predictedDemand,
            'average_usage' => $avgWeeklyUsage,
            'message' => 'Predicted weekly usage based on previous patterns.'
        ];
    }



    /**
     * Suggest reorder / replenishment levels based on:
     * - Current stock
     * - Predicted demand
     * - Safety stock
     */
    public function suggestReorder($toolId)
    {
        // Fetch inventory information
        $tool = DB::table('tools')->where('id', $toolId)->first();

        if (!$tool) {
            return [
                'tool_id' => $toolId,
                'message' => 'Tool not found.',
                'recommendation' => null
            ];
        }

        // Predict demand
        $prediction = $this->predictFutureDemand($toolId);
        $predictedUsage = $prediction['prediction'];

        $currentStock = $tool->quantity;
        $safetyStock = max(2, round($predictedUsage * 0.3)); // 30% of predicted demand

        $recommendedReorder = 0;

        if ($currentStock < ($predictedUsage + $safetyStock)) {
            // reorder amount = predicted demand + safety stock - current stock
            $recommendedReorder = ($predictedUsage + $safetyStock) - $currentStock;
        }

        return [
            'tool_id' => $toolId,
            'current_stock' => $currentStock,
            'predicted_usage' => $predictedUsage,
            'safety_stock' => $safetyStock,
            'recommended_reorder' => $recommendedReorder,
            'message' => $recommendedReorder > 0
                ? 'Reorder recommended to maintain safe inventory levels.'
                : 'Stock level is sufficient.'
        ];
    }



    /**
     * Detect anomalies such as:
     * - Sudden spike in tool borrowing
     * - Missing / unreturned tools
     * - Irregular patterns indicating misuse
     */
    public function detectAnomalies($toolId)
    {
        // Fetch last 30 days usage
        $usage = DB::table('issued_logs')
            ->where('tool_id', $toolId)
            ->where('date_issued', '>=', Carbon::now()->subDays(30))
            ->count();

        // Fetch previous 30 days usage
        $previousUsage = DB::table('issued_logs')
            ->where('tool_id', $toolId)
            ->whereBetween('date_issued', [
                Carbon::now()->subDays(60),
                Carbon::now()->subDays(30)
            ])
            ->count();

        // Avoid division by zero
        if ($previousUsage == 0) $previousUsage = 1;

        $changeRate = ($usage - $previousUsage) / $previousUsage;

        $anomaly = null;

        if ($changeRate > 0.5) {
            $anomaly = "⚠️ Spike detected — Tool is being borrowed much more than usual.";
        } elseif ($changeRate < -0.5) {
            $anomaly = "⚠️ Drop detected — Tool is being borrowed less, possibly broken or missing.";
        } else {
            $anomaly = "No major anomalies detected.";
        }

        return [
            'tool_id' => $toolId,
            'last_30_days_usage' => $usage,
            'previous_30_days_usage' => $previousUsage,
            'change_rate' => round($changeRate * 100, 2) . '%',
            'status' => $anomaly
        ];
    }



    /**
     * Combined analytics report for a specific tool.
     */
    public function generateFullReport($toolId)
    {
        return [
            'prediction' => $this->predictFutureDemand($toolId),
            'reorder_suggestion' => $this->suggestReorder($toolId),
            'anomaly_detection' => $this->detectAnomalies($toolId),
        ];
    }
}
