<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enroll;

class ApiEnrollController extends Controller
{
    // Fetch all enrollments
    public function index(Request $request)
    {
        $enrolls = Enroll::all();
        return response()->json($enrolls, 200);
    }

    // Fetch enrollment by code
    public function showByCode(Request $request, $code_enroll)
    {
        $enroll = Enroll::where('code_enroll', $code_enroll)->first();

        if (!$enroll) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        return response()->json($enroll, 200);
    }
}
