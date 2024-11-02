<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiUserController extends Controller
{
    //
    // Fungsi Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'user_id' => $user->id, // Kembalikan user_id
                'data' => $user,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function profile($user_id)
    {
        $user = User::with('role')->find($user_id);
        
        if ($user) {
            return response()->json([
                'name' => $user->name,
                'nomor_induk' => $user->nomor_induk,
                'tahun_masuk' => $user->tahun_masuk,
                'role' => $user->role->name,
            ]);
        }

        return response()->json([
            'message' => 'User not found',
        ], 404);
    }
}