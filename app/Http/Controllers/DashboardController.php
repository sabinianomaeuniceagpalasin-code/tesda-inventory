<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ---------- Dashboard Stats ----------
        $totalIssuedItems = DB::table('issuedlog')->count();
        $totalItems = DB::table('items')->count();
        $availableItems = DB::table('items')->where('status', 'Available')->count();
        $issuedItems = DB::table('items')->where('status', 'Issued')->count();
        $forRepair = DB::table('items')->whereIn('status', ['For Repair', 'Damaged'])->count();
        $missingItems = DB::table('items')->where('status', 'Lost')->count();
        $lowStockThreshold = 5;
        $lowStock = DB::table('propertyinventory')->where('quantity', '<', $lowStockThreshold)->count();
        $itemsUsage = DB::table('issuedlog')
            ->select(
                'serial_no',
                DB::raw('SUM(usage_hours) as total_usage_hours')
            )
            ->groupBy('serial_no');

        // ---------- Inventory ----------
        $inventory = DB::table('items')
            ->select('status', 'serial_no', 'item_name', 'source_of_fund', 'classification', DB::raw('DATE(date_acquired) as date_acquired'))
            ->get();

        // ---------- Issued Items List ----------
        $issuedItemsList = DB::table('issuedlog')
            ->leftJoin('formrecords', 'issuedlog.reference_no', '=', 'formrecords.reference_no')
            ->leftJoin('items', 'issuedlog.serial_no', '=', 'items.serial_no')
            ->select(
                'issuedlog.property_no',
                'formrecords.student_name as issued_to',
                'formrecords.issued_by as issued_by',
                'issuedlog.issued_date',
                'items.item_name as item'
            )
            ->orderBy('issuedlog.issued_date', 'desc')
            ->get();

        // ---------- Form Records ----------
        $issuedForms = DB::table('formrecords')
            ->select('id', 'form_type', 'reference_no', 'created_at', 'student_name', 'item_count', 'status')
            ->orderBy('created_at', 'desc')
            ->get();

        $formSummaryCounts = (object) [
            'total_forms' => $issuedForms->count(),
            'ics_forms' => $issuedForms->where('form_type', 'ICS')->count(),
            'par_forms' => $issuedForms->where('form_type', 'PAR')->count(),
            'active_forms' => $issuedForms->where('status', 'Active')->count(),
            'archived_forms' => $issuedForms->where('status', 'Archived')->count(),
        ];

        // ---------- Usage & Issued Frequency ----------
        $issuedFrequency = DB::table('issuedlog')
            ->join('items', 'issuedlog.serial_no', '=', 'items.serial_no')
            ->select('items.item_name', DB::raw('COUNT(*) as total'))
            ->groupBy('items.item_name')
            ->get();

        $usageData = DB::table('items')
            ->select('item_name')
            ->groupBy('item_name')
            ->get();

        // ---------- Maintenance Records ----------
        $maintenanceRecords = DB::table('maintenancerecords')
            ->join('items', 'maintenancerecords.item_id', '=', 'items.item_id')
            ->select(
                'maintenancerecords.*',
                'items.item_name',
                'items.property_no',
                'items.serial_no'
            )
            ->orderBy('maintenancerecords.date', 'DESC')
            ->get();



        // ---------- Predictive / Prescriptive Maintenance ----------
        $maintenanceForecast = DB::table('items')
            ->leftJoinSub($itemsUsage, 'usage', function ($join) {
                $join->on('items.serial_no', '=', 'usage.serial_no');
            })
            ->select(
                'items.item_id',
                'items.item_name',
                'items.serial_no',
                DB::raw("IFNULL(items.maintenance_threshold_usage, 0) as maintenance_threshold_usage"),
                'items.last_maintenance_date',
                'items.maintenance_interval_days',
                DB::raw("DATE_ADD(items.last_maintenance_date, INTERVAL items.maintenance_interval_days DAY) as next_maintenance_date"),
                DB::raw("IFNULL(usage.total_usage_hours, 0) as total_usage_hours")
            )
            ->get();

        $maintenanceCounts = [
            'total' => $maintenanceRecords->count(),
            'pending' => $maintenanceRecords->where('status', 'Pending')->count(),
            'completed' => $maintenanceRecords->where('status', 'Completed')->count(),
            'upcoming' => $maintenanceRecords->where('date', '>', now())->count(),
        ];

        $overdueMaintenance = $maintenanceForecast
            ->filter(function ($item) {
                return $item->next_maintenance_date && Carbon::parse($item->next_maintenance_date)->isPast();
            });

        $upcomingMaintenance = $maintenanceForecast
            ->filter(function ($item) {
                return $item->next_maintenance_date
                    && Carbon::parse($item->next_maintenance_date)->between(now(), now()->addDays(7));
            });

        $usageAlerts = DB::table('items')
            ->leftJoinSub($itemsUsage, 'usage', function ($join) {
                $join->on('items.serial_no', '=', 'usage.serial_no');
            })
            ->whereNotNull('maintenance_threshold_usage')
            ->select(
                'items.item_name',
                'items.serial_no',
                DB::raw('IFNULL(usage.total_usage_hours, 0) as total_usage_hours'),
                'items.maintenance_threshold_usage',
                DB::raw('items.maintenance_threshold_usage - IFNULL(usage.total_usage_hours, 0) AS remaining_hours')
            )
            ->orderBy('remaining_hours', 'ASC')
            ->get();


        $highRiskItems = $maintenanceForecast->filter(function ($item) {
            $threshold = $item->maintenance_threshold_usage;
            $overUsage = $threshold > 0 && $item->total_usage_hours >= $threshold;
            $overdue = $item->next_maintenance_date && Carbon::parse($item->next_maintenance_date)->isPast();
            return $overUsage || $overdue;
        });

        // ---------- Return view ----------
        return view('dashboard', compact(
            'totalItems',
            'availableItems',
            'issuedItems',
            'forRepair',
            'lowStock',
            'missingItems',
            'inventory',
            'issuedForms',
            'formSummaryCounts',
            'issuedFrequency',
            'usageData',
            'maintenanceRecords',
            'maintenanceCounts',
            'issuedItemsList',
            'totalIssuedItems',
            'maintenanceForecast',
            'overdueMaintenance',
            'upcomingMaintenance',
            'usageAlerts',
            'highRiskItems'
        ));
    }
}
