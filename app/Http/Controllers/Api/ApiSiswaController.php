<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiSiswaController extends Controller
{
    //

    public function index()
    {
        $siswas = \App\Models\Siswa::all();
        return response()->json($siswas, 200);
    }
}
