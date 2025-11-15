<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    // ✅ Inventory index
    public function index()
    {
        // Get inventory grouped by property_no to show quantity
        $inventory = DB::table('property_inventory')
            ->select('property_no', 'tool_name', 'quantity')
            ->get();

        $totalTools     = DB::table('tools')->count();
        $availableItems = DB::table('tools')->where('status', 'Available')->count();
        $issuedItems    = DB::table('tools')->where('status', 'Borrowed')->count();
        $forRepair      = DB::table('tools')->whereIn('status', ['For Repair', 'Damaged'])->count();

        return view('dashboard', compact('inventory', 'totalTools', 'availableItems', 'issuedItems', 'forRepair'));
    }

    // ✅ Check if property number exists and return its details
    public function checkPropertyNo($property_no)
    {
        $tool = DB::table('tools')
            ->select('tool_name', 'classification', 'source_of_fund', 'date_acquired')
            ->where('property_no', $property_no)
            ->first();

        if ($tool) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'tool_name'      => $tool->tool_name,
                    'classification' => $tool->classification,
                    'source_of_fund' => $tool->source_of_fund,
                    'date_acquired'  => $tool->date_acquired,
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    // ✅ Store new item
    public function store(Request $request)
{
    $validated = $request->validate([
        'tool_name'      => 'required|string',
        'classification' => 'required|string',
        'source_of_fund' => 'required|string',
        'date_acquired'  => 'required|date',
        'property_no'    => 'required|string',
        'quantity'       => 'required|integer|min:1',
        'unit_cost'      => 'required|numeric|min:0',
        'remarks'        => 'nullable|string',
    ]);

    $quantity = $validated['quantity'];

    DB::transaction(function() use ($validated, $quantity) {

        // Get last SN number for this property_no
        $lastNumber = DB::table('tools')
            ->where('property_no', $validated['property_no'])
            ->where('serial_no', 'like', 'SN%')
            ->lockForUpdate()
            ->max(DB::raw('CAST(SUBSTRING(serial_no, 3) AS UNSIGNED)'));

        $lastNumber = $lastNumber ?: 0;

        for ($i = 1; $i <= $quantity; $i++) {
            // Increment lastNumber until we find a free serial
            do {
                $lastNumber++;
                $serial_no = 'SN' . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
                $exists = DB::table('tools')->where('serial_no', $serial_no)->exists();
            } while ($exists);

            DB::table('tools')->insert([
                'tool_name'      => $validated['tool_name'],
                'classification' => $validated['classification'],
                'source_of_fund' => $validated['source_of_fund'],
                'date_acquired'  => $validated['date_acquired'],
                'property_no'    => $validated['property_no'],
                'serial_no'      => $serial_no,
                'stock'          => 1,
                'remarks'        => $validated['remarks'],
                'status'         => 'Available',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // Update property_inventory
        DB::table('property_inventory')->updateOrInsert(
            ['property_no' => $validated['property_no']],
            [
                'tool_name'  => $validated['tool_name'],
                'quantity'   => DB::raw("COALESCE(quantity,0) + $quantity"),
                'unit_cost'  => $validated['unit_cost'],
                'updated_at' => now(),
            ]
        );
    });

    return redirect()->back()->with('success', "✅ Added {$quantity} item(s) successfully!");
}
}
