<?php

namespace App\Http\Controllers;

use App\Imports\GuruPelajaranImport;
use App\Models\GuruPelajaran;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */ public function index(Request $request)
    {
        // Fetch all filters from the request
        $guruId = $request->input('guru_id');
        $mataPelajaranId = $request->input('mata_pelajaran_id');
        $enroll_code = $request->input('enroll_code');

        // Query the database with the applied filters
        $guruPelajarans = GuruPelajaran::with('guru', 'mataPelajaran')
            ->when($guruId, function ($query, $guruId) {
                return $query->where('guru_id', $guruId);
            })
            ->when($mataPelajaranId, function ($query, $mataPelajaranId) {
                return $query->where('mata_pelajaran_id', $mataPelajaranId);
            })
            ->get();

        // Fetch all gurus and mata pelajarans for the filter dropdowns
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();

        return view('guru_pelajarans.index', compact('guruPelajarans', 'gurus', 'mataPelajarans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::all(); // Fetch all gurus
        $mataPelajarans = MataPelajaran::all(); // Fetch all mata pelajaran

        return view('guru_pelajarans.create', compact('gurus', 'mataPelajarans'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'enroll_code' => 'required|string|max:255',
        ]);

        GuruPelajaran::create($validated);

        return redirect()->route('guru_pelajarans.index')->with('success', 'Guru Pelajaran created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GuruPelajaran $guruPelajaran)
    {
        return view('guru_pelajarans.show', compact('guruPelajaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruPelajaran $guruPelajaran)
    {
        $gurus = Guru::all(); // Fetch all Gurus for the dropdown
        $mataPelajarans = MataPelajaran::all(); // Fetch all MataPelajarans for the dropdown
        return view('guru_pelajarans.edit', compact('guruPelajaran', 'gurus', 'mataPelajarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuruPelajaran $guruPelajaran)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'enroll_code' => 'required|string|max:255',
        ]);

        $guruPelajaran->update($validated);

        return redirect()->route('guru_pelajarans.index')->with('success', 'Guru Pelajaran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruPelajaran $guruPelajaran)
    {
        $guruPelajaran->delete();

        return redirect()->route('guru_pelajarans.index')->with('success', 'Guru Pelajaran deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new GuruPelajaranImport, $request->file('file'));

        return redirect()->back()->with('success', 'Gurus imported successfully.');
    }
}
