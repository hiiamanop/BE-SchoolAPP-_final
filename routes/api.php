<?php

use App\Http\Controllers\Api\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!'], 200);
});

// test
use App\Http\Controllers\Api\TestController;

Route::get('/test-controller', [TestController::class, 'index']);

// auth
Route::post('/login', [App\Http\Controllers\Api\ApiUserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\Api\ApiUserController::class, 'logout']);

// profile tanpa middleware
Route::get('/user/profile', [App\Http\Controllers\Api\ApiUserController::class, 'profile']);



// book
Route::get('/buku', [App\Http\Controllers\Api\ApiBukuController::class, 'index']);
Route::get('/buku/{id}', [App\Http\Controllers\Api\ApiBukuController::class, 'show']);
Route::get('/buku/{id}/downlaod', [App\Http\Controllers\Api\ApiBukuController::class, 'download']);

// enroll
use App\Http\Controllers\Api\ApiEnrollController;
use App\Http\Controllers\Api\ApiEnrollClassController;

// Fetch all enrollments
Route::get('/enrollments', [ApiEnrollController::class, 'index']);

// Fetch enrollment by enrollment code
Route::get('/enrollments/code/{code_enroll}', [ApiEnrollController::class, 'showByCode']);

// Fetch all enrolled classes for a student
Route::get('/enrollments/classes', [ApiEnrollClassController::class, 'index']);

// Enroll a student in a class using the enrollment code
Route::post('/enrollments/join', [ApiEnrollClassController::class, 'store']);



