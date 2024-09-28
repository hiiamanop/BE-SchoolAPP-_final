<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiBukuController extends Controller
{
    //

    public function index()
    {
        $bukus = \App\Models\Buku::all();
        return response()->json($bukus, 200);
    }
    
}
