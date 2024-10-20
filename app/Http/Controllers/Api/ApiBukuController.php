<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

class ApiBukuController extends Controller
{

    public function index()
    {
        $kategori = request()->query('kategori_buku_id');  // Get the category from query parameters

        if ($kategori) {
            $bukus = Buku::where('kategori_buku_id', $kategori)->get();
        } else {
            $bukus = Buku::all();
        }

        return response()->json($bukus, 200);
    }

    // Retrieve the book with the PDF URL
    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        // Return the book details with the PDF file URL
        return response()->json([
            'id' => $buku->id,
            'judul' => $buku->judul,
            'kategori_buku_id' => $buku->kategori_buku_id,
            'pdf_url' => url(Storage::url($buku->pdf_path)),
        ]);
    }

    public function download($id)
    {
        $buku = Buku::findOrFail($id);
        $pdfPath = storage_path('app/public/pdf/' . $buku->pdf_file); // Adjust the path accordingly

        if (file_exists($pdfPath)) {
            return response()->file($pdfPath);
        }

        return response()->json(['message' => 'File not found'], 404);
    }
}
