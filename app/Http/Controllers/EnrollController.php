<?php

namespace App\Http\Controllers;

use App\Models\Enroll;
use Illuminate\Http\Request;

class EnrollController extends Controller
{
    /**
     * Display a listing of the enrolls.
     */
    public function index()
    {
        $enrolls = Enroll::with('guruPelajaran')->get();
        return response()->json($enrolls);
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

        $enroll = Enroll::create($validatedData);
        return response()->json($enroll, 201);
    }

    /**
     * Display the specified enroll.
     */
    public function show($id)
    {
        $enroll = Enroll::with('guruPelajaran')->findOrFail($id);
        return response()->json($enroll);
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

        return response()->json($enroll);
    }

    /**
     * Remove the specified enroll.
     */
    public function destroy($id)
    {
        $enroll = Enroll::findOrFail($id);
        $enroll->delete();

        return response()->json(null, 204);
    }
}
