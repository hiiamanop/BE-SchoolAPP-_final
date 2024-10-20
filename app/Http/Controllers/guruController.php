<?php

namespace App\Http\Controllers;

use App\Imports\GuruImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    protected $roleGuru = 2; // ID untuk role guru

    public function index(Request $request)
    {
        // Query untuk mendapatkan user dengan role guru (role_id = 2)
        $query = User::where('role_id', $this->roleGuru);

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
            'email' => 'required|email|unique:users,email', // Menggunakan tabel users
            'password' => 'required|string|min:8|confirmed',
            'nomor_induk' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|digits:4',
        ]);

        // Buat user dengan role guru
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $this->roleGuru, // Set role_id untuk guru
            'nomor_induk' => $validated['nomor_induk'] ?? null,
            'tahun_masuk' => $validated['tahun_masuk'] ?? null,
        ]);

        return redirect()->route('gurus.index')->with('success', 'Guru created successfully.');
    }

    public function update(Request $request, User $guru)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->id, // Unik di tabel users
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

    public function edit(User $guru)
    {
        return view('gurus.edit', compact('guru'));
    }

    public function destroy(User $guru)
    {
        $guru->delete();

        return redirect()->route('gurus.index')->with('success', 'Guru deleted successfully.');
    }

    public function import(Request $request)
    {
        // Validate that the uploaded file is an Excel file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Perform the import
        Excel::import(new GuruImport, $request->file('file'));

        return redirect()->back()->with('success', 'Gurus imported successfully.');
    }
}
