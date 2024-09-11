<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Display a listing of gurus
    public function index()
    {
        $gurus = User::where('role_id', 2) // Assuming role_id 2 represents guru
                     ->get();
        return view('gurus.index', compact('gurus'));
    }

    // Show the form for creating a new guru
    public function create()
    {
        return view('gurus.create');
    }

    // Store a newly created guru in storage
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
            'role_id' => 2, // Assuming role_id 2 represents guru
        ]);

        return redirect()->route('gurus.index')->with('success', 'Guru created successfully.');
    }

    // Show the form for editing the specified guru
    public function edit(User $guru)
    {
        return view('gurus.edit', compact('guru'));
    }

    // Update the specified guru in storage
    public function update(Request $request, User $guru)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $guru->name = $validated['name'];
        $guru->email = $validated['email'];
        if ($request->filled('password')) {
            $guru->password = Hash::make($validated['password']);
        }
        $guru->save();

        return redirect()->route('gurus.index')->with('success', 'Guru updated successfully.');
    }

    // Remove the specified guru from storage
    public function destroy(User $guru)
    {
        $guru->delete();

        return redirect()->route('gurus.index')->with('success', 'Guru deleted successfully.');
    }
}
