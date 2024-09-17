<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Assignment;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soals = Soal::with('assignment')->get();
        return view('soals.index', compact('soals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignments = Assignment::all(); // Fetch all assignments for the dropdown
        return view('soals.create', compact('assignments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'soal' => 'required|string',
            'type' => 'required|integer',
        ]);

        Soal::create($request->all());

        return redirect()->route('soals.index')->with('success', 'Soal created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function show(Soal $soal)
    {
        return view('soals.show', compact('soal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit(Soal $soal)
    {
        $assignments = Assignment::all(); // Fetch all assignments for the dropdown
        return view('soals.edit', compact('soal', 'assignments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soal $soal)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'soal' => 'required|string',
            'type' => 'required|integer',
        ]);

        $soal->update($request->all());

        return redirect()->route('soals.index')->with('success', 'Soal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Soal $soal)
    {
        $soal->delete();

        return redirect()->route('soals.index')->with('success', 'Soal deleted successfully.');
    }
}
