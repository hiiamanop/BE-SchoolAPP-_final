<?php

// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List all roles
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    // Show form to create new role
    public function create()
    {
        return view('roles.create');
    }

    // Store a new role
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,role',
        ]);

        Role::create($request->only('role'));

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    // Show form to edit a role
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Update a role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
        ]);

        $role->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    // Delete a role
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
