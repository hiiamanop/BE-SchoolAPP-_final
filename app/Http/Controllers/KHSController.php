<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\JenisPenilaian;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    /**
     * Display a listing of the KHS records.
     */
    public function index()
    {
        $khs = KHS::with(['siswa', 'mataPelajaran', 'jenisPenilaian', 'tahunAjaran'])->get();
        $siswas = Siswa::all();
        $mataPelajarans = MataPelajaran::all();
        $jenisPenilaians = JenisPenilaian::all();
        $tahunAjarans = TahunAjaran::all();


        // Pass the data to the view
        return view('khs.index', [
            'khs' => $khs,
            'siswas' => $siswas,
            'mataPelajarans' => $mataPelajarans,
            'jenisPenilaians' => $jenisPenilaians,
            'tahunAjarans' => $tahunAjarans
        ]);
    }

    /**
     * Show the form for creating a new KHS record.
     */
    public function create()
    {
        $siswas = Siswa::all();
        $mataPelajarans = MataPelajaran::all();
        $jenisPenilaians = JenisPenilaian::all();
        $tahunAjarans = TahunAjaran::all();

        return view('khs.create', compact('siswas', 'mataPelajarans', 'jenisPenilaians', 'tahunAjarans'));
    }

    /**
     * Store a newly created KHS record in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jenis_penilaian_id' => 'required|exists:jenis_penilaians,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nilai' => 'required|string',
        ]);

        KHS::create($request->all());

        return redirect()->route('khs.index')->with('success', 'KHS record created successfully.');
    }

    /**
     * Show the form for editing the specified KHS record.
     */
    public function edit($id)
    {
        $khs = KHS::findOrFail($id);
        $siswas = Siswa::all();
        $mataPelajarans = MataPelajaran::all();
        $jenisPenilaians = JenisPenilaian::all();
        $tahunAjarans = TahunAjaran::all();

        return view('khs.edit', compact('khs', 'siswas', 'mataPelajarans', 'jenisPenilaians', 'tahunAjarans'));
    }

    /**
     * Update the specified KHS record in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jenis_penilaian_id' => 'required|exists:jenis_penilaians,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nilai' => 'required|string',
        ]);

        $khs = KHS::findOrFail($id);
        $khs->update($request->all());

        return redirect()->route('khs.index')->with('success', 'KHS record updated successfully.');
    }

    /**
     * Remove the specified KHS record from the database.
     */
    public function destroy($id)
    {
        $khs = KHS::findOrFail($id);
        $khs->delete();

        return redirect()->route('khs.index')->with('success', 'KHS record deleted successfully.');
    }
}
