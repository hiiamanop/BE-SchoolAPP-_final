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
    public function login(Request $request)
    {
        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        // Percobaan login
        if (Auth::attempt($data)) {
            $user = Auth::user();

            // Mengecek apakah user memiliki role yang diizinkan (role_id = 3)
            if ($user->role_id == 3) {
                
                // Menghapus token lama (opsional)
                $user->tokens()->delete();

                // Membuat token baru
                $token = $user->createToken('auth_token')->plainTextToken;

                // Mengembalikan data user dan token ke klien
                return response()->json([
                    'success' => true,
                    'message' => 'Login Berhasil',
                    'auth_token' => $token,
                    'data' => $user,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda Tidak Punya Akses',
                    'data' => null,
                ], 403);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username / Password Salah',
                'data' => null,
            ], 401);
        }
    }

    public function logout()
    {
        try {
            // Mendapatkan user yang sedang login
            $user = Auth::user();
            
            // Menghapus semua token user
            $user->tokens()->delete();

            // Mengembalikan respons berhasil logout
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil',
                'data' => null
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => 'Logout Gagal',
                'data' => $error->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data User Berhasil Diambil',
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User Tidak Ditemukan',
                    'data' => null
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
