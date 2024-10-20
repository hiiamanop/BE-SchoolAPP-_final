<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    protected $roleSiswa = 3; // ID untuk role siswa

    public function index(Request $request)
    {
        // Query untuk mendapatkan user dengan role siswa (role_id = 3)
        $query = User::where('role_id', $this->roleSiswa);

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

        $siswas = $query->get();

        return view('siswas.index', compact('siswas'));
    }

    public function create()
    {
        return view('siswas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users', // Menggunakan tabel users
            'password' => 'required|min:6|confirmed',
            'nomor_induk' => 'nullable',
            'tahun_masuk' => 'nullable|integer',
        ]);

        // Buat user dengan role siswa
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nomor_induk' => $request->nomor_induk,
            'tahun_masuk' => $request->tahun_masuk,
            'role_id' => $this->roleSiswa, // Set role_id untuk siswa
        ]);

        return redirect()->route('siswas.index')->with('success', 'Siswa created successfully.');
    }

    public function edit(User $siswa)
    {
        return view('siswas.edit', compact('siswa'));
    }

    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $siswa->id, // Unik di tabel users
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

    public function destroy(User $siswa)
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
