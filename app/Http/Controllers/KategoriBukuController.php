<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $kategoriBukus = KategoriBuku::all();
        return view('kategori_buku.index', compact('kategoriBukus'));
    }


    // Show the form for creating a new category
    public function create()
    {
        return view('kategori_buku.create');
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        // Create the new category
        KategoriBuku::create([
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('kategori_buku.index')->with('success', 'Category created successfully.');
    }


    // Show the form for editing the specified category
    public function edit(KategoriBuku $kategori_buku)
    {
        return view('kategori_buku.edit', compact('kategori_buku'));
    }

    // Update the specified category in storage
    public function update(Request $request, KategoriBuku $kategori_buku)
    {
        // Validate the request
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        // Update the category
        $kategori_buku->update([
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('kategori_buku.index')->with('success', 'Category updated successfully.');
    }

    // Remove the specified category from storage
    public function destroy(KategoriBuku $kategoriBuku)
    {
        $kategoriBuku->delete();

        return redirect()->route('kategori_buku.index')->with('success', 'Category deleted successfully.');
    }
}
