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

        Auth::attempt($data);
        if (Auth::check()) {


            if (Auth::user()->role_id == 3) {
                $userId = Auth::user()->id;
                $user = User::where('id', $userId)->first();

                // menggunakan format json
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Login Berhasil',
                        'data' => $user
                    ],
                    200
                );
            } else {
                $user = null;
                // menggunakan format json
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Anda Tidak Punya Akses',
                        'data' => null
                    ],
                    500
                );
            }
        } else {
            $user = null;
            // menggunakan format json
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Username / Password Salah',
                    'data' => null
                ],
                500
            );
        }
    }

    public function logout()
    {
        try {
            $logout = Auth::logout();

            // if($logout) {
            // menggunakan format json
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Logout Berhasil',
                    'data' => null
                ],
                200
            );
            // } else {
            // menggunakan format json
            //     return response()->json(
            //         [
            //             'success' => true,
            //             'message' => 'Logout Gagal',
            //             'data' => null
            //         ],
            //         500
            //     );
            // }
        } catch (Exception $error) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Logout Gagal',
                    'data' => $error->getMessage()
                ],
                500
            );
        }
    }
}
