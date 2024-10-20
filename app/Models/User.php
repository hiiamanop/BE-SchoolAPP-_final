<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'nomor_induk',
        'tahun_masuk',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
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

    public function guruPelajaran()
    {
        return $this->hasMany(GuruPelajaran::class);
    }
    

}
