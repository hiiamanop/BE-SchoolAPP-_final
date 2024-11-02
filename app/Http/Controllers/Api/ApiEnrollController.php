<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\EnrollClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApiEnrollController extends Controller
{
    public function getEnrolledClasses($userId)
    {
        try {
            Log::info('Starting fetch enrolled classes', ['user_id' => $userId]);

            // Enable query logging for debugging
            DB::enableQueryLog();

            $enrolledClasses = EnrollClass::with([
                'enroll' => function ($query) {
                    $query->select('id', 'code_enroll', 'guru_pelajaran_id');
                },
                'enroll.guruPelajaran' => function ($query) {
                    $query->select('id', 'user_id', 'mata_pelajaran_id');
                },
                'enroll.guruPelajaran.mataPelajaran' => function ($query) {
                    $query->select('id', 'name'); // Mengubah 'nama' menjadi 'name'
                },
                'enroll.guruPelajaran.user' => function ($query) {
                    $query->select('id', 'name')
                        ->where('role_id', 2);
                }
            ])
            ->where('user_id', $userId)
            ->get();

            // Log the queries for debugging
            Log::info('Queries executed:', DB::getQueryLog());
            
            // Log the raw data for debugging
            Log::info('Raw enrolled classes data:', [
                'data' => $enrolledClasses->toArray()
            ]);

            $formattedClasses = $enrolledClasses->map(function ($enrollClass) {
                try {
                    $guruPelajaran = $enrollClass->enroll->guruPelajaran;
                    
                    // Log the individual class data for debugging
                    Log::info('Processing class:', [
                        'enroll_class_id' => $enrollClass->id,
                        'guru_pelajaran' => $guruPelajaran ? $guruPelajaran->toArray() : null,
                        'mata_pelajaran' => $guruPelajaran->mataPelajaran ? $guruPelajaran->mataPelajaran->toArray() : null,
                        'user' => $guruPelajaran->user ? $guruPelajaran->user->toArray() : null,
                    ]);

                    return [
                        'id' => $enrollClass->id,
                        'mata_pelajaran' => $guruPelajaran->mataPelajaran->name ?? 'Tidak tersedia', // Mengubah nama menjadi name
                        'guru' => $guruPelajaran->user->name ?? 'Tidak tersedia',
                        'code_enroll' => $enrollClass->enroll->code_enroll ?? 'Tidak tersedia',
                        // Tambahkan data debug
                        'mata_pelajaran_id' => $guruPelajaran->mata_pelajaran_id ?? null,
                        'guru_pelajaran_id' => $enrollClass->enroll->guru_pelajaran_id ?? null,
                    ];
                } catch (\Exception $e) {
                    Log::error('Error formatting class data', [
                        'enroll_class_id' => $enrollClass->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return null;
                }
            })->filter();

            return response()->json([
                'status' => 'success',
                'data' => $formattedClasses
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching enrolled classes', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch enrolled classes: ' . $e->getMessage()
            ], 500);
        }
    }
}