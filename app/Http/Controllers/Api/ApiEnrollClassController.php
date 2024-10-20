<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrollClass;
use App\Models\Enroll;
use Exception;

class ApiEnrollClassController extends Controller
{
    // Fetch all enrollments of classes
    public function index(Request $request)
    {
        $enrolls = EnrollClass::all();
        return response()->json($enrolls, 200);
    }

    // Enroll a student to a class using the code
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:siswas,id',
            'code_enroll' => 'required|string',
        ]);

        try {

            // Check if the enrollment code exists
            $enroll = Enroll::where('code_enroll', $request->code_enroll)->first();

            if (!$enroll) {
                return response()->json(['message' => 'Invalid enrollment code'], 404);
            }

            // Create the enroll class relationship
            $enrollClass = EnrollClass::create([
                'user_id' => $request->user_id,
                'enroll_id' => $enroll->id,
            ]);

            return response()->json($enrollClass, 201);
            //code...
        } catch (Exception $error) {
            //throw $th;
            // response gagal
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Post Data Gagal ' . $error->getMessage(),
                    'data' => []
                ],
                500
            );
        }
    }
}
