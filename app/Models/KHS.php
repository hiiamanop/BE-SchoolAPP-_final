<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;

    protected $table = '_k_h_s'; // Explicitly define the table name

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'jenis_penilaian_id',
        'tahun_ajaran_id',
        'nilai',
    ];

    /**
     * Get the siswa that owns the KHS.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Mata Pelajaran for the KHS.
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    /**
     * Get the Jenis Penilaian for the KHS.
     */
    public function jenisPenilaian()
    {
        return $this->belongsTo(JenisPenilaian::class, 'jenis_penilaian_id');
    }

    /**
     * Get the Tahun Ajaran for the KHS.
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
