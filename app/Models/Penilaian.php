<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_id',
        'assignment_id',
        'jumlah_soal',
        'max_score',
        'pilgan_score',
        'essay_score',
    ];

    /**
     * Get the Siswa (student) associated with the penilaian.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Assignment associated with the penilaian.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
