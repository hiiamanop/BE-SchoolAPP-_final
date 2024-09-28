<?php

// ApiEnrollController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\EnrollClass;
use Illuminate\Http\Request;

class ApiEnrollController extends Controller
{
    // Join a class
    public function joinClass(Request $request)
    {
        // Validate request
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'guru_pelajaran_id' => 'required|exists:guru_pelajarans,id',
            'code_enroll' => 'required|string'
        ]);

        // Check if the enroll data matches with the given guru_pelajaran_id and code_enroll
        $enroll = Enroll::where('guru_pelajaran_id', $request->guru_pelajaran_id)
                        ->where('code_enroll', $request->code_enroll)
                        ->first();

        if ($enroll) {
            // Check if the student is already enrolled in the class
            $existingEnroll = EnrollClass::where('siswa_id', $request->siswa_id)
                                         ->where('enroll_id', $enroll->id)
                                         ->first();

            if ($existingEnroll) {
                return response()->json(['message' => 'You are already enrolled in this class.'], 409);
            }

            // Enroll the student in the class
            EnrollClass::create([
                'siswa_id' => $request->siswa_id,
                'enroll_id' => $enroll->id
            ]);

            return response()->json(['message' => 'Successfully enrolled in the class.'], 201);
        } else {
            return response()->json(['message' => 'Invalid class code or teacher.'], 404);
        }
    }
}


