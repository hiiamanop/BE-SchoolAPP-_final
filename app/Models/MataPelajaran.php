<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'mata_pelajarans';

    // The attributes that are mass assignable.
    protected $fillable = ['name'];

    // Optional: if you want to customize timestamps column names or format, you can do so here.
    public $timestamps = true; // This is the default, so you can omit this line if you prefer.
}
