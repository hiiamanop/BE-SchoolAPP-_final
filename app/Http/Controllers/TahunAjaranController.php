<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // Display a listing of the resources
    public function index()
    {
        $tahunAjarans = TahunAjaran::all();
        return view('tahun_ajarans.index', compact('tahunAjarans'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('tahun_ajarans.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        // Validate the inputs
        $validated = $request->validate([
            'start_year' => 'required|numeric|digits:4',
            'end_year' => 'required|numeric|digits:4|gte:start_year',
        ]);

        // Create a new Tahun Ajaran
        TahunAjaran::create([
            'name' => $validated['start_year'] . '/' . $validated['end_year'], // concatenate start and end year
            'start_year' => $validated['start_year'],
            'end_year' => $validated['end_year'],
        ]);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran created successfully.');
    }



    // Show the form for editing the specified resource
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun-ajaran.edit', compact('tahunAjaran'));
    }

    // Update the specified resource in storage
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        // Validate the inputs
        $validated = $request->validate([
            'start_year' => 'required|numeric|digits:4',
            'end_year' => 'required|numeric|digits:4|gte:start_year',
        ]);

        // Update the Tahun Ajaran
        $tahunAjaran->update([
            'start_year' => $validated['start_year'],
            'end_year' => $validated['end_year'],
            'name' => $validated['start_year'] . '/' . $validated['end_year'], // Update the name field as start_year/end_year
        ]);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran updated successfully.');
    }


    // Remove the specified resource from storage
    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran deleted successfully.');
    }
}
