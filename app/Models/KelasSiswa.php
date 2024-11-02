<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kelas_id'];

    // Relationship to the User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to the Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
