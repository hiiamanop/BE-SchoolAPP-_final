<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    // Display a listing of mata pelajaran
    public function index()
    {
        $mataPelajarans = MataPelajaran::all();
        return view('mata_pelajarans.index', compact('mataPelajarans'));
    }

    // Show the form for creating a new mata pelajaran
    public function create()
    {
        return view('mata_pelajarans.create');
    }

    // Store a newly created mata pelajaran in storage
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new mata pelajaran
        MataPelajaran::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran created successfully.');
    }

    // Show the form for editing the specified mata pelajaran
    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('mata_pelajarans.edit', compact('mataPelajaran'));
    }

    // Update the specified mata pelajaran in storage
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the mata pelajaran
        $mataPelajaran->name = $validated['name'];
        $mataPelajaran->save();

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran updated successfully.');
    }

    // Remove the specified mata pelajaran from storage
    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran deleted successfully.');
    }
}
