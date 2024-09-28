<?php

// ApiEnrollClassController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EnrollClass;
use Illuminate\Http\Request;

class ApiEnrollClassController extends Controller
{
    // Get all enrolled classes for a specific student (siswa)
    public function index(Request $request)
    {
        $siswaId = $request->siswa_id; // Assume siswa_id comes from the request
        $enrolledClasses = EnrollClass::with('enroll.guruPelajaran')
            ->where('siswa_id', $siswaId)
            ->get();

        return response()->json($enrolledClasses, 200);
    }
}
