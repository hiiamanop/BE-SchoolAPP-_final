<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Display a listing of admins
    public function index()
    {
        $admins = User::where('role_id', 1) // Assuming role_id 1 represents admin
                      ->get();
        return view('admins.index', compact('admins'));
    }

    // Show the form for creating a new admin
    public function create()
    {
        return view('admins.create');
    }

    // Store a newly created admin in storage
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new admin
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 1, // Assuming role_id 1 represents admin
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }

    // Show the form for editing the specified admin
    public function edit(User $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    // Update the specified admin in storage
    public function update(Request $request, User $admin)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the admin
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        if ($request->filled('password')) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();

        return redirect()->route('admins.index')->with('success', 'Admin updated successfully.');
    }

    // Remove the specified admin from storage
    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully.');
    }
}
