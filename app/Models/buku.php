<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_buku_id',
        'judul',
        'pdf_path',  // Add this line
    ];

    public function kategoriBuku()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_buku_id');
    }
}
