<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiPenilaianController extends Controller
{
    //
    public function index()
    {
        $penilaians = \App\Models\Penilaian::all();
        return response()->json($penilaians, 200);
    }
}
