<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class KelasController extends Controller
{
    // Display a listing of the classes
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    // Show the form for creating a new class
    public function create()
    {
        return view('kelas.create');
    }

    // Store a newly created class in storage
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create the new class
        Kelas::create([
            'name' => $request->name,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Class created successfully.');
    }

    // Show the form for editing the specified class
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    // Update the specified class in storage
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the 'kelas' record
        $kelas->name = $request->name;
        $kelas->save();

        // Redirect back with success message
        return redirect()->route('kelas.index')->with('success', 'Kelas updated successfully.');
    }

    // Remove the specified class from storage
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Class deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',  // Ensure the file is an XLSX
        ]);

        DB::beginTransaction();

        try {
            // Import the file using Laravel Excel
            Excel::import(new KelasImport, $request->file('file'));

            DB::commit();
            return redirect()->route('kelas.index')->with('success', 'Classes imported successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kelas.index')->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
}
