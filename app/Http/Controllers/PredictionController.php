<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PredictionController extends Controller
{
    public function show($propertyNo)
    {
        // Get usage history (issued records)
        $issued = DB::table('issued_summary')
            ->where('property_no', $propertyNo)
            ->orderBy('created_at')
            ->get();

        // Get damage history
        $damages = DB::table('item_damages')
            ->where('property_no', $propertyNo)
            ->orderBy('damaged_at')
            ->get();

        $usageCount = $issued->count();
        $damageCount = $damages->count();

        // ---------- DAMAGE PROBABILITY ----------
        $damageProbability = $usageCount > 0 ? $damageCount / $usageCount : 0;

        // ---------- PREDICT NEXT DAMAGE DATE ----------
        if ($damageCount >= 2) {
            $intervals = [];

            for ($i = 1; $i < $damageCount; $i++) {
                $intervals[] = Carbon::parse($damages[$i]->damaged_at)
                    ->diffInDays(Carbon::parse($damages[$i - 1]->damaged_at));
            }

            $avgInterval = collect($intervals)->avg();
            $predictedDate = Carbon::parse($damages->last()->damaged_at)
                ->addDays($avgInterval)
                ->toDateString();
        } else {
            $predictedDate = "Not enough data";
        }

        // ---------- RISK LEVEL ----------
        $riskLevel = "Low";
        if ($damageProbability > 0.6) $riskLevel = "High";
        elseif ($damageProbability > 0.3) $riskLevel = "Medium";

        return view('analytics.prediction', [
            'propertyNo'            => $propertyNo,
            'usageCount'            => $usageCount,
            'damageCount'           => $damageCount,
            'damageProbability'     => round($damageProbability, 2),
            'predictedDamageDate'   => $predictedDate,
            'riskLevel'             => $riskLevel
        ]);
    }
}
