<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Display a listing of books
    public function index()
    {
        // Fetch all bukus and kategori_bukus
        $bukus = Buku::with('kategoriBuku')->get();
        $kategori_bukus = KategoriBuku::all();

        // Pass bukus and kategori_bukus to the view
        return view('bukus.index', compact('bukus', 'kategori_bukus'));
    }


    // Show the form for creating a new book
    public function create()
    {
        // Retrieve all categories to populate the dropdown
        $kategoriBukus = KategoriBuku::all();

        return view('bukus.create', compact('kategoriBukus'));
    }


    // Store a newly created book in storage
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_buku_id' => 'required|exists:kategori_bukus,id',
        ]);

        // Create a new book
        buku::create([
            'judul' => $validated['judul'],
            'kategori_buku_id' => $validated['kategori_buku_id'],
        ]);

        return redirect()->route('bukus.index')->with('success', 'Book created successfully.');
    }

    // Show the form for editing the specified book
    public function edit(buku $buku)
    {
        $kategori_bukus = KategoriBuku::all(); // Fetch all book categories
        return view('bukus.edit', compact('buku', 'kategori_bukus'));
    }

    // Update the specified book in storage
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_buku_id' => 'required|exists:kategori_bukus,id', // Validate foreign key
        ]);

        $buku->update([
            'judul' => $request->input('judul'),
            'kategori_buku_id' => $request->input('kategori_buku_id'),
        ]);

        return redirect()->route('bukus.index')->with('success', 'Buku updated successfully');
    }

    // Remove the specified book from storage
    public function destroy(buku $buku)
    {
        $buku->delete();

        return redirect()->route('bukus.index')->with('success', 'Book deleted successfully.');
    }
}
