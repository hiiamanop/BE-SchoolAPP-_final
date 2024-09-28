<?php

namespace App\Http\Controllers;

use App\Models\EnrollClass;
use Illuminate\Http\Request;

class EnrollClassController extends Controller
{
    /**
     * Display a listing of the enrollments.
     */
    public function index()
    {
        $enrollClasses = EnrollClass::with(['enroll', 'siswa'])->get();
        return response()->json($enrollClasses);
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

        $enrollClass = EnrollClass::create($validatedData);
        return response()->json($enrollClass, 201);
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
        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'enroll_id' => 'required|exists:enrolls,id',
        ]);

        $enrollClass = EnrollClass::findOrFail($id);
        $enrollClass->update($validatedData);

        return response()->json($enrollClass);
    }

    /**
     * Remove the specified enrollment.
     */
    public function destroy($id)
    {
        $enrollClass = EnrollClass::findOrFail($id);
        $enrollClass->delete();

        return response()->json(null, 204);
    }
}
