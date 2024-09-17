<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mata_pelajaran_id',
        'jenis_penilaian_id',
        'token_id',
        'code_assignment',
    ];

    /**
     * Get the Mata Pelajaran (subject) associated with the assignment.
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    /**
     * Get the Jenis Penilaian (type of assessment) associated with the assignment.
     */
    public function jenisPenilaian()
    {
        return $this->belongsTo(JenisPenilaian::class);
    }

    /**
     * Get the Token associated with the assignment.
     */
    public function token()
    {
        return $this->belongsTo(Token::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function soals()
{
    return $this->hasMany(Soal::class);
}

}
