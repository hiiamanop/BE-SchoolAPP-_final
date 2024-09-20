<?php

namespace App\Http\Controllers;

use App\Imports\GuruImport;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->filled('nomor_induk')) {
            $query->where('nomor_induk', $request->input('nomor_induk'));
        }

        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->input('tahun_masuk'));
        }

        $gurus = $query->get();

        return view('gurus.index', compact('gurus'));
    }



    public function createImport()
    {
        return view('gurus.import');
    }

    public function create()
    {
        return view('gurus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email',
            'password' => 'required|string|min:8|confirmed',
            'nomor_induk' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|digits:4',
        ]);

        Guru::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2, // Role ID for guru
            'nomor_induk' => $validated['nomor_induk'] ?? null,
            'tahun_masuk' => $validated['tahun_masuk'] ?? null,
        ]);

        return redirect()->route('gurus.index')->with('success', 'Guru created successfully.');
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:gurus,email,' . $guru->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nomor_induk' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|digits:4',
        ]);

        $guru->name = $validated['name'];
        $guru->email = $validated['email'];
        if ($request->filled('password')) {
            $guru->password = Hash::make($validated['password']);
        }
        $guru->nomor_induk = $validated['nomor_induk'] ?? $guru->nomor_induk;
        $guru->tahun_masuk = $validated['tahun_masuk'] ?? $guru->tahun_masuk;
        $guru->save();

        return redirect()->route('gurus.index')->with('success', 'Guru updated successfully.');
    }

    public function edit(Guru $guru)
    {
        return view('gurus.edit', compact('guru'));
    }


    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('gurus.index')->with('success', 'Guru deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new GuruImport, $request->file('file'));

        return redirect()->back()->with('success', 'Gurus imported successfully.');
    }
}
