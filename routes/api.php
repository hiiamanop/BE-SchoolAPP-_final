<?php

use App\Http\Controllers\API\ApiEnrollController;
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
Route::post('/login', [ApiUserController::class, 'login']);
Route::get('/profile/{id}', [ApiUserController::class, 'profile']);

// book
Route::get('/buku', [App\Http\Controllers\Api\ApiBukuController::class, 'index']);
Route::get('/buku/{id}', [App\Http\Controllers\Api\ApiBukuController::class, 'show']);
Route::get('/buku/{id}/downlaod', [App\Http\Controllers\Api\ApiBukuController::class, 'download']);

// enrollment
Route::middleware(['cors'])->group(function () {
    Route::post('/enroll', [ApiEnrollController::class, 'enrollToClass']);
    Route::get('/enrolled-classes/{userId}', [ApiEnrollController::class, 'getEnrolledClasses']);
});
