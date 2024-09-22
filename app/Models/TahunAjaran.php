<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_year', 'end_year'];

    public function k_h_s()
{
    return $this->hasMany(KHS::class);
}

}

