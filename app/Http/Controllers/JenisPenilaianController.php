<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use Illuminate\Http\Request;

class JenisPenilaianController extends Controller
{
    // Display a listing of jenis penilaian
    public function index()
    {
        $jenisPenilaians = JenisPenilaian::all();
        return view('jenis_penilaians.index', compact('jenisPenilaians'));
    }

    // Show the form for creating a new jenis penilaian
    public function create()
    {
        return view('jenis_penilaians.create');
    }

    // Store a newly created jenis penilaian in storage
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new jenis penilaian
        JenisPenilaian::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('jenis-penilaian.index')->with('success', 'Jenis Penilaian created successfully.');
    }

    // Show the form for editing the specified jenis penilaian
    public function edit(JenisPenilaian $jenisPenilaian)
    {
        return view('jenis_penilaians.edit', compact('jenisPenilaian'));
    }

    // Update the specified jenis penilaian in storage
    public function update(Request $request, JenisPenilaian $jenisPenilaian)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the jenis penilaian
        $jenisPenilaian->name = $validated['name'];
        $jenisPenilaian->save();

        return redirect()->route('jenis-penilaian.index')->with('success', 'Jenis Penilaian updated successfully.');
    }

    // Remove the specified jenis penilaian from storage
    public function destroy(JenisPenilaian $jenisPenilaian)
    {
        $jenisPenilaian->delete();

        return redirect()->route('jenis-penilaian.index')->with('success', 'Jenis Penilaian deleted successfully.');
    }
}
