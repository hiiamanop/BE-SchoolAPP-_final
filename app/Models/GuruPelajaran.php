<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
    ];

    // Relationships

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}