<?php

namespace App\Http\Controllers;

use App\Imports\SoalImport;
use App\Models\Soal;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
        $assignmentId = $request->input('assignment_id');

        // Filter Soals based on the assignment_id, if selected
        $soals = Soal::with('assignment')
            ->when($assignmentId, function ($query, $assignmentId) {
                return $query->where('assignment_id', $assignmentId);
            })
            ->get();

        $assignments = Assignment::all(); // Fetch all assignments for the filter dropdown

        return view('soals.index', compact('soals', 'assignments'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $assignments = Assignment::all(); // Retrieve all assignments
        return view('soals.create', compact('assignments'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'soal' => 'required|string|max:255',
            'type' => 'required|integer',
        ]);

        Soal::create($validated);
        return redirect()->route('soals.index')->with('success', 'Soal created successfully.');
    }

    // Show the form for editing the specified resource
    public function edit(Soal $soal)
    {
        $assignments = Assignment::all();
        return view('soals.edit', compact('soal', 'assignments'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Soal $soal)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'soal' => 'required|string|max:255',
            'type' => 'required|integer',
        ]);

        $soal->update($validated);
        return redirect()->route('soals.index')->with('success', 'Soal updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Soal $soal)
    {
        $soal->delete();
        return redirect()->route('soals.index')->with('success', 'Soal deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx', // Validate the file as an XLSX format
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new SoalImport, $request->file('file')); // Use the SoalImport class to handle the import
            DB::commit();
            return redirect()->route('soals.index')->with('success', 'Soals imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('soals.index')->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
}
