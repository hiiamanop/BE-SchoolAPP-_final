<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // Display a listing of siswa
    public function index()
    {
        $siswa = User::where('role_id', 3) // Assuming role_id 3 represents siswa
                     ->get();
        return view('siswas.index', compact('siswa'));
    }

    // Show the form for creating a new siswa
    public function create()
    {
        return view('siswas.create');
    }

    // Store a newly created siswa in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 3, // Assuming role_id 3 represents siswa
        ]);

        return redirect()->route('siswas.index')->with('success', 'Siswa created successfully.');
    }

    // Show the form for editing the specified siswa
    public function edit(User $siswa)
    {
        return view('siswas.edit', compact('siswa'));
    }

    // Update the specified siswa in storage
    public function update(Request $request, User $siswa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $siswa->name = $validated['name'];
        $siswa->email = $validated['email'];
        if ($request->filled('password')) {
            $siswa->password = Hash::make($validated['password']);
        }
        $siswa->save();

        return redirect()->route('siswas.index')->with('success', 'Siswa updated successfully.');
    }

    // Remove the specified siswa from storage
    public function destroy(User $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswas.index')->with('success', 'Siswa deleted successfully.');
    }
}
