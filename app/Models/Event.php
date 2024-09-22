<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatan',
        'assignment_id',
        'tanggal',
    ];

    /**
     * Define a relationship with the Assignment model.
     * Assuming the Assignment model exists.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
