<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollClass extends Model
{
    use HasFactory;

    protected $table = 'enroll_class';

    protected $fillable = [
        'siswa_id',
        'enroll_id'
    ];

    /**
     * Get the guru_pelajaran associated with the enrollment.
     */
    public function enroll()
    {
        return $this->belongsTo(Enroll::class, 'enroll_id');
    }

    /**
     * Get the siswa associated with the enrollment.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }
}
