<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Assignment;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penilaians = Penilaian::with('siswa', 'assignment')->get(); // Retrieve penilaians with relationships
        $siswas = Siswa::all(); // Retrieve all students
        $assignments = Assignment::all(); // Retrieve all assignments

        return view('penilaians.index', compact('penilaians', 'siswas', 'assignments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswas = Siswa::all(); // Fetch all students
        $assignments = Assignment::all(); // Fetch all assignments
        return view('penilaians.create', compact('siswas', 'assignments'));
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
            'siswa_id' => 'required|exists:siswas,id',
            'assignment_id' => 'required|exists:assignments,id',
            'jumlah_soal' => 'required|integer',
            'max_score' => 'required|integer',
            'pilgan_score' => 'required|integer',
            'essay_score' => 'required|integer',
        ]);

        Penilaian::create($request->all());

        return redirect()->route('penilaians.index')->with('success', 'Penilaian created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian)
    {
        return view('penilaians.show', compact('penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function edit(Penilaian $penilaian)
    {
        $siswas = Siswa::all(); // Fetch all students for dropdown
        $assignments = Assignment::all(); // Fetch all assignments for dropdown
        return view('penilaians.edit', compact('penilaian', 'siswas', 'assignments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'assignment_id' => 'required|exists:assignments,id',
            'jumlah_soal' => 'required|integer',
            'max_score' => 'required|integer',
            'pilgan_score' => 'required|integer',
            'essay_score' => 'required|integer',
        ]);

        $penilaian->update($request->all());

        return redirect()->route('penilaians.index')->with('success', 'Penilaian updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();

        return redirect()->route('penilaians.index')->with('success', 'Penilaian deleted successfully.');
    }
}
