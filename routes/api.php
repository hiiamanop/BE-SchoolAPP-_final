<?php

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

// book
Route::get('/bukus', [App\Http\Controllers\Api\ApiBukuController::class, 'index']);
Route::post('/bukus', [App\Http\Controllers\Api\ApiBukuController::class, 'store']);
Route::get('/bukus/{id}', [App\Http\Controllers\Api\ApiBukuController::class, 'show']);
Route::put('/bukus/{id}', [App\Http\Controllers\Api\ApiBukuController::class, 'update']);
Route::delete('/bukus/{id}', [App\Http\Controllers\Api\ApiBukuController::class, 'destroy']);
