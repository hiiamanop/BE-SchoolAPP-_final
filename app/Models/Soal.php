<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assignment_id',
        'soal',
        'type',
    ];

    /**
     * Get the Assignment associated with the soal.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function lembarJawaban()
    {
        return $this->hasMany(LembarJawaban::class);
    }

    public function pilihanGanda()
    {
        return $this->hasMany(PilihanGanda::class);
    }
}
