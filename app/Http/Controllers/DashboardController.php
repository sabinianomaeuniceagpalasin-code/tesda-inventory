<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ---------- Dashboard Stats ----------
        $totalTools = DB::table('tools')->count();
        $availableItems = DB::table('tools')->where('status', 'Available')->count();
        $issuedItems = DB::table('tools')->where('status', 'Issued')->count();
        $forRepair = DB::table('tools')->whereIn('status', ['For Repair', 'Damaged'])->count();
        $lowStockThreshold = 5;
        $lowStock = DB::table('property_inventory')->where('quantity', '<', $lowStockThreshold)->count();
        $missingItems = DB::table('tools')->where('status', 'Lost')->count();

        $inventory = DB::table('tools')
            ->select('status', 'serial_no', 'tool_name', 'source_of_fund', 'classification', DB::raw('DATE(date_acquired) as date_acquired'))
            ->get();

        // ---------- Form Records ----------
        $issuedForms = DB::table('issued_summary')
            ->select('id', 'form_type', 'reference_no', 'created_at', 'student_name', 'item_count', 'status')
            ->orderBy('created_at', 'desc')
            ->get();

        $formSummaryCounts = DB::table('issued_summary')
            ->select(
                DB::raw('COUNT(*) as total_forms'),
                DB::raw("SUM(form_type = 'ICS') as ics_forms"),
                DB::raw("SUM(form_type = 'PAR') as par_forms"),
                DB::raw("SUM(status = 'Active') as active_forms"),
                DB::raw("SUM(status = 'Archived') as archived_forms")
            )
            ->first();

        // ---------- Usage & Issued Frequency ----------
        $issuedFrequency = DB::table('issued_log')
            ->join('tools', 'issued_log.serial_no', '=', 'tools.serial_no')
            ->select('tools.tool_name', DB::raw('COUNT(*) as total'))
            ->groupBy('tools.tool_name')
            ->get();

        $usageData = DB::table('tools')
            ->select('tool_name')
            ->groupBy('tool_name')
            ->get();

        // ---------- Maintenance Data ----------
        $maintenanceRecords = DB::table('maintenance_records')
            ->select(
                'property_no',
                'item_name',
                'issue_problem',
                'date_reported',
                'repair_cost',
                'expected_completion',
                'remarks',
            )
            ->orderBy('date_reported', 'DESC')
            ->get();

        $maintenanceCounts = [
            'total' => $maintenanceRecords->count(),
            'pending' => $maintenanceRecords->where('status', 'Pending')->count(),
            'completed' => $maintenanceRecords->where('status', 'Completed')->count(),
            'upcoming' => $maintenanceRecords->where('expected_completion', '>', now())->count(),
        ];

        // ---------- Return view ----------
        return view('dashboard', compact(
            'totalTools',
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
            'maintenanceCounts'
        ));
    }
}
