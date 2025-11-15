<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class IssuedLogController extends Controller
{
    /**
     * Return student matches for suggestions
     */
    public function searchStudents(Request $request)
    {
        $q = $request->get('query', '');
        if (strlen($q) < 1) {
            return response()->json([]);
        }

        $students = DB::table('student')
            ->select('id','student_name','student_number','batch')
            ->where('student_name', 'LIKE', "%{$q}%")
            ->limit(10)
            ->get();

        return response()->json($students);
    }

    /**
     * Return available serial numbers for tools
     */
    public function availableSerials(Request $request)
    {
        try {
            $query = DB::table('tools')->where('status', 'Available');

            if ($request->has('property_no') && $request->property_no != '') {
                $query->where('property_no', $request->property_no);
            }

            $tools = $query->get(['serial_no', 'property_no', 'tool_name']);

            return response()->json($tools);

        } catch (\Exception $e) {
            \Log::error('Available serials error: '.$e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * Quick check if reference number already exists
     */
    public function checkReference($reference)
    {
        $exists = DB::table('issued_summary')
            ->where('reference_no', $reference)
            ->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Store the issuance and update tools
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_name' => 'required|string',
            'selected_serials' => 'required|array|min:1',
            'selected_serials.*' => 'required|string',
            'form_type' => ['required', Rule::in(['ICS','PAR'])],
            'issued_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:issued_date',
            'reference_no' => 'required|string|unique:issued_summary,reference_no',
        ]);

        $issuedDate = Carbon::parse($data['issued_date'])->toDateString();
        $returnDate = $data['return_date']
            ? Carbon::parse($data['return_date'])->toDateString()
            : null;

        $insertedIds = [];

        // Insert each serial into issued_logs
        foreach ($data['selected_serials'] as $serial) {
            $tool = DB::table('tools')->where('serial_no', $serial)->first();
            $propertyNo = $tool ? $tool->property_no : null;

            $id = DB::table('issued_logs')->insertGetId([
                'student_name' => $data['student_name'],
                'serial_no' => $serial,
                'property_no' => $propertyNo,
                'form_type' => $data['form_type'],
                'issued_date' => $issuedDate,
                'return_date' => $returnDate,
                'reference_no' => $data['reference_no'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $insertedIds[] = $id;

            // Update tool status
            if ($tool) {
                DB::table('tools')->where('serial_no', $serial)->update([
                    'status' => 'Issued',
                    'updated_at' => now()
                ]);
            }
        }

        // Create summary grouped by property_no
        $summary = collect($data['selected_serials'])->map(function($serial) {
            return DB::table('tools')->where('serial_no', $serial)->value('property_no');
        })->filter()->countBy(); // property_no => count

        foreach ($summary as $propertyNo => $count) {
            DB::table('issued_summary')->insert([
                'property_no' => $propertyNo,
                'item_count' => $count,
                'student_name' => $data['student_name'],
                'form_type' => $data['form_type'],
                'status' => 'Active',
                'reference_no' => $data['reference_no'], // add reference number
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Issued log and summary created successfully',
            'inserted' => $insertedIds,
            'data' => [
                'student_name' => $data['student_name'],
                'selected_serials' => $data['selected_serials'],
                'form_type' => $data['form_type'],
                'issued_date' => $issuedDate,
                'return_date' => $returnDate,
                'reference_no' => $data['reference_no'],
            ]
        ]);
    }

    /**
     * Show all Form Records from issued_summary
     */
    public function indexForms()
    {
        $issuedForms = DB::table('issued_summary')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('form_records', compact('issuedForms'));
    }
}
