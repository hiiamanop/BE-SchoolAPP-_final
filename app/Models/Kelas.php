<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function siswas()
    {
        return $this->hasMany(KelasSiswa::class, 'kelas_id');
    }
}
