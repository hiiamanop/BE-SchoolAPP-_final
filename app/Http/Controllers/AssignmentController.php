<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\MataPelajaran;
use App\Models\JenisPenilaian;
use App\Models\Token;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the assignments.
     */
    public function index()
    {
        $assignments = Assignment::with('mataPelajaran', 'jenisPenilaian', 'token')->get();
        $mataPelajarans = MataPelajaran::all();
        $jenisPenilaians = JenisPenilaian::all();
        $tokens = Token::all();

        return view('assignments.index', compact('assignments', 'mataPelajarans', 'jenisPenilaians', 'tokens'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        $jenisPenilaians = JenisPenilaian::all();
        $tokens = Token::all();

        return view('assignments.create', compact('mataPelajarans', 'jenisPenilaians', 'tokens'));
    }

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jenis_penilaian_id' => 'required|exists:jenis_penilaians,id',
            'token_id' => 'required|exists:tokens,id',
            'code_assignment' => 'required|string|max:255',
        ]);

        // Create a new assignment
        Assignment::create($request->all());

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified assignment.
     */
    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified assignment.
     */
    public function edit(Assignment $assignment)
    {
        $mataPelajarans = MataPelajaran::all();
        $jenisPenilaians = JenisPenilaian::all();
        $tokens = Token::all();

        return view('assignments.edit', compact('assignment', 'mataPelajarans', 'jenisPenilaians', 'tokens'));
    }

    /**
     * Update the specified assignment in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        // Validate incoming data
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jenis_penilaian_id' => 'required|exists:jenis_penilaians,id',
            'token_id' => 'required|exists:tokens,id',
            'code_assignment' => 'required|string|max:255',
        ]);

        // Update the assignment
        $assignment->update($request->all());

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified assignment from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
