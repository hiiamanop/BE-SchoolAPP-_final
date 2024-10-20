<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembarJawaban extends Model
{
    use HasFactory;

    protected $table = 'lembar_jawaban'; // Nama tabelnya 'lembar_jawaban'

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'siswa_id',
        'soal_id',
        'jawaban_siswa',
        'score', // Ini nullable karena score akan diberikan setelah guru memeriksa jawaban
    ];

    // Relasi ke Soal
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    // Relasi ke Siswa melalui Soal (karena soal terkait dengan assignment dan assignment terkait siswa)
    public function user()
    {
        return $this->hasOneThrough(User::class, Soal::class, 'id', 'id', 'soal_id', 'user_id');
    }

    // Relasi ke Assignment melalui Soal
    public function assignment()
    {
        return $this->hasOneThrough(Assignment::class, Soal::class, 'id', 'id', 'soal_id', 'assignment_id');
    }
}
