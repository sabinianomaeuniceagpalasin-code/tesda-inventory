<?php

namespace App\ML;

class PrescriptiveEngine
{
    public static function decide(float $predictedCondition)
    {
        if ($predictedCondition < 3) {
            return [
                'action' => 'maintenance_required',
                'message' => 'Tool should be sent for maintenance.',
                'risk' => 'high',
            ];
        }

        if ($predictedCondition < 5) {
            return [
                'action' => 'monitor',
                'message' => 'Tool is degrading, monitor closely.',
                'risk' => 'medium',
            ];
        }

        return [
            'action' => 'good',
            'message' => 'Tool is in good condition.',
            'risk' => 'low',
        ];
    }
}
