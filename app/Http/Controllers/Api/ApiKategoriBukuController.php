<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiKategoriBukuController extends Controller
{
    //
    public function index()
    {
        $kategoribukus = \App\Models\KategoriBuku::all();
        return response()->json($kategoribukus, 200);
    }
}
