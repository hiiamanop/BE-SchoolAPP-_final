<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanGanda extends Model
{
    use HasFactory;

    protected $table = 'pilihan_gandas';

    protected $fillable = [
        'soal_id',
        'jawaban',
        'value',
    ];

    protected $casts = [
        'value' => 'boolean',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}