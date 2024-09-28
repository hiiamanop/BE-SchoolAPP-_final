<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'nomor_induk',
        'tahun_masuk'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kelasSiswa()
    {
        return $this->hasMany(kelasSiswa::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function khs()
    {
        return $this->hasMany(KHS::class);
    }

    public function lembarJawaban()
    {
        return $this->hasMany(LembarJawaban::class);
    }

    public function enrollClass()
    {
        return $this->hasMany(EnrollClass::class);
    }
}
