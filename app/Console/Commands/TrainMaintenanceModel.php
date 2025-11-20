<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ML\PredictiveMaintenance;
use Illuminate\Support\Facades\DB;

class TrainMaintenanceModel extends Command
{
    protected $signature = 'ml:train-maintenance';
    protected $description = 'Train predictive maintenance ML model';

    public function handle()
    {
        $records = DB::table('tools')
            ->join('maintenance_records', 'tools.id', '=', 'maintenance_records.tool_id')
            ->select(
                'usage_hours',
                'previous_failures',
                'age_in_months',
                'days_since_last_maintenance',
                'days_until_failure'
            )
            ->whereNotNull('days_until_failure')
            ->get();

        if ($records->isEmpty()) {
            $this->error("No training data available.");
            return;
        }

        $samples = [];
        $targets = [];

        foreach ($records as $r) {
            $samples[] = [
                $r->usage_hours,
                $r->previous_failures,
                $r->age_in_months,
                $r->days_since_last_maintenance
            ];
            $targets[] = $r->days_until_failure;
        }

        PredictiveMaintenance::train($samples, $targets);

        $this->info("Predictive maintenance model trained successfully.");
    }
}
