<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'tokens';

    // The attributes that are mass assignable.
    protected $fillable = ['value', 'lifetime'];

    // Optional: if you want to customize timestamps column names or format, you can do so here.
    public $timestamps = true; // This is the default, so you can omit this line if you prefer.

    // Optionally, specify the type of the 'lifetime' attribute as a date.
    protected $dates = ['lifetime'];
}
