<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollClass extends Model
{
    use HasFactory;

    protected $table = 'enroll_class';

    protected $fillable = [
        'user_id',
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
