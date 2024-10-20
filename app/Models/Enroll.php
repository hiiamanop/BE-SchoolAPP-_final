<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;

    protected $table = 'enrolls';

    protected $fillable = [
        'guru_pelajaran_id',
        'code_enroll',
    ];

    /**
     * Get the guru_pelajaran associated with the enrollment.
     */
    public function guruPelajaran()
    {
        return $this->belongsTo(GuruPelajaran::class, 'guru_pelajaran_id');
    }

    public function enrollClass()
    {
        return $this->hasMany(EnrollClass::class);
    }

    public function assigment()
    {
        return $this->hasMany(Assignment::class);
    }
}
