<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $tahun_masuk = $request->input('tahun_masuk'); // Get filter from the request

        // Check if filter exists, apply it, otherwise get all records
        if ($tahun_masuk) {
            $siswas = Siswa::where('tahun_masuk', $tahun_masuk)->get();
        } else {
            $siswas = Siswa::all();
        }

        return view('siswas.index', compact('siswas', 'tahun_masuk'));
    }


    public function create()
    {
        return view('siswas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:siswas',
            'password' => 'required|min:6|confirmed',
            'nomor_induk' => 'nullable',
            'tahun_masuk' => 'nullable|integer',
        ]);

        Siswa::create($request->only('name', 'email', 'password', 'nomor_induk', 'tahun_masuk'));

        return redirect()->route('siswas.index')->with('success', 'Siswa created successfully.');
    }

    public function edit(Siswa $siswa)
    {
        return view('siswas.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:siswas,email,' . $siswa->id,
            'password' => 'nullable|min:6|confirmed',
            'nomor_induk' => 'nullable',
            'tahun_masuk' => 'nullable|integer',
        ]);

        $data = $request->only('name', 'email', 'nomor_induk', 'tahun_masuk');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $siswa->update($data);

        return redirect()->route('siswas.index')->with('success', 'Siswa updated successfully.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswas.index')->with('success', 'Siswa deleted successfully.');
    }

    public function import1(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Siswas imported successfully.');
    }
}
