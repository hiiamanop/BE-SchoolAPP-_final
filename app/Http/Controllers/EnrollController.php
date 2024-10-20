<?php

namespace App\Http\Controllers;

use App\Imports\EnrollImport;
use App\Models\Enroll;
use App\Models\GuruPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EnrollController extends Controller
{
    /**
     * Display a listing of the enrolls.
     */
    public function index(Request $request)
    {
        // Get the selected guru_pelajaran_id from the request
        $guruPelajaranId = $request->query('guru_pelajaran_id');

        // Get the list of GuruPelajaran for dropdowns
        $guruPelajaranList = GuruPelajaran::all();

        // Query the Enroll model
        if ($guruPelajaranId) {
            $enrolls = Enroll::where('guru_pelajaran_id', $guruPelajaranId)
                ->with('guruPelajaran')
                ->get();
        } else {
            $enrolls = Enroll::with('guruPelajaran')->get();
        }

        return view('enroll.index', [
            'enrolls' => $enrolls,
            'guruPelajaranList' => $guruPelajaranList
        ]);
    }

    /**
     * Store a newly created enroll.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guru_pelajaran_id' => 'required|exists:guru_pelajarans,id',
            'code_enroll' => 'required|string|max:255',
        ]);

        Enroll::create($validatedData);

        return redirect()->route('enrolls.index')->with('success', 'Enrollment created successfully!');
    }

    /**
     * Update the specified enroll.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'guru_pelajaran_id' => 'required|exists:guru_pelajarans,id',
            'code_enroll' => 'required|string|max:255',
        ]);

        $enroll = Enroll::findOrFail($id);
        $enroll->update($validatedData);

        return redirect()->route('enrolls.index')->with('success', 'Enrollment updated successfully!');
    }

    /**
     * Remove the specified enroll.
     */
    public function destroy($id)
    {
        $enroll = Enroll::findOrFail($id);
        $enroll->delete();

        return redirect()->route('enrolls.index')->with('success', 'Enrollment deleted successfully!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new EnrollImport, $request->file('file'));
            DB::commit();

            return redirect()->route('enrolls.index')->with('success', 'Enrollments imported successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('enrolls.index')->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
}
