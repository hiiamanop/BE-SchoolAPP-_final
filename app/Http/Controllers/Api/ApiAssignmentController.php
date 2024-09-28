<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class ApiAssignmentController extends Controller
{
    //

    public function index()
    {
        $assignments = Assignment::all();
        return response()->json($assignments, 200);
    }
}
