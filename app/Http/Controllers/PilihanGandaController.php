<?php

namespace App\Http\Controllers;

use App\Imports\PilihanGandaImport;
use App\Models\PilihanGanda;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PilihanGandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $soalId = $request->input('soal_id');

        // Filter PilihanGandas based on the soal_id, if selected
        $pilihanGandas = PilihanGanda::with('soal')
            ->when($soalId, function ($query, $soalId) {
                return $query->where('soal_id', $soalId);
            })
            ->get();

        $soals = Soal::all(); // Fetch all soals for the filter dropdown

        return view('pilihan_ganda.index', compact('pilihanGandas', 'soals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $soals = Soal::all();
        return view('pilihan_ganda.create', compact('soals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'soal_id' => 'required|exists:soals,id',
            'jawaban' => 'required|string',
            'value' => 'required|boolean',
        ]);

        PilihanGanda::create($validatedData);

        return redirect()->route('pilihan_ganda.index')
            ->with('success', 'Pilihan ganda created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PilihanGanda $pilihanGanda)
    {
        return view('pilihan_ganda.show', compact('pilihanGanda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PilihanGanda $pilihanGanda)
    {
        $soals = Soal::all();
        return view('pilihan_ganda.edit', compact('pilihanGanda', 'soals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PilihanGanda $pilihanGanda)
    {
        $validatedData = $request->validate([
            'soal_id' => 'required|exists:soals,id',
            'jawaban' => 'required|string',
            'value' => 'required|boolean',
        ]);

        $pilihanGanda->update($validatedData);

        return redirect()->route('pilihan_ganda.index')
            ->with('success', 'Pilihan ganda updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PilihanGanda $pilihanGanda)
    {
        $pilihanGanda->delete();

        return redirect()->route('pilihan_ganda.index')
            ->with('success', 'Pilihan ganda deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx', // Validate the file as an XLSX format
        ]);

        DB::beginTransaction();

        try {
            Excel::import(new PilihanGandaImport, $request->file('file')); // Use the PilihanGandaImport class to handle the import
            DB::commit();
            return redirect()->route('pilihan_gandas.index')->with('success', 'Pilihan Gandas imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pilihan_gandas.index')->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
}
