<?php

namespace App\Http\Controllers;

use App\Imports\EnrollClassImport;
use App\Models\Enroll;
use App\Models\EnrollClass;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EnrollClassController extends Controller
{
    /**
     * Display a listing of the enrollments.
     */
    public function index(Request $request)
    {
        $filterEnrollId = $request->input('enroll_id');

        // Fetch all enroll classes with siswa, enroll, guru, and class details
        $query = EnrollClass::with(['siswa', 'enroll.guruPelajaran.guru']);

        // Filter if enroll_id is provided
        if ($filterEnrollId) {
            $query->where('enroll_id', $filterEnrollId);
        }

        $enrollClasses = $query->get();

        // Fetch all students and enrollments for the dropdowns
        $siswas = Siswa::all();
        $enrolls = Enroll::all();

        return view('enroll_class.index', compact('enrollClasses', 'siswas', 'enrolls', 'filterEnrollId'));
    }



    /**
     * Store a newly created enrollment.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'enroll_id' => 'required|exists:enrolls,id',
        ]);

        EnrollClass::create($validatedData);

        // Redirect to the index route
        return redirect()->route('enroll_classes.index')->with('success', 'Enroll class added successfully!');
    }


    /**
     * Display the specified enrollment.
     */
    public function show($id)
    {
        $enrollClass = EnrollClass::with(['enroll', 'siswa', 'assignment'])->findOrFail($id);
        return response()->json($enrollClass);
    }

    /**
     * Update the specified enrollment.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'enroll_id' => 'required|exists:enrolls,id',
        ]);

        $enrollClass = EnrollClass::findOrFail($id);
        $enrollClass->update([
            'siswa_id' => $request->siswa_id,
            'enroll_id' => $request->enroll_id,
        ]);

        return redirect()->route('enroll_classes.index')->with('success', 'Enroll class updated successfully!');
    }


    /**
     * Remove the specified enrollment.
     */
    public function destroy($id)
    {
        $enrollClass = EnrollClass::findOrFail($id);
        $enrollClass->delete();

        // Redirect to the index route
        return redirect()->route('enroll_classes.index')->with('success', 'Enroll class deleted successfully!');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new EnrollClassImport, $request->file('file'));

            DB::commit();
            return redirect()->route('bukus.index')->with('success', 'Books imported successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('bukus.index')->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
}
