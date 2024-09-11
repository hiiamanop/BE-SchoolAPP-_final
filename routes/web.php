<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Add other authenticated routes here
});

use App\Http\Controllers\RoleController;

// Role management
Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class)->except(['show']);
});

use App\Http\Controllers\AdminController;

// Admin management
Route::resource('admins', AdminController::class)->middleware('auth');

use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;

// Guru management
Route::resource('gurus', GuruController::class)->middleware('auth');

// Siswa management
Route::resource('siswas', SiswaController::class)->middleware('auth');

use App\Http\Controllers\BukuController;

// Buku management
Route::resource('bukus', BukuController::class);

use App\Http\Controllers\KategoriBukuController;

// Kategori Buku management
Route::resource('kategori_buku', KategoriBukuController::class);


use App\Http\Controllers\KelasController;

// Kelas management
Route::resource('kelas', KelasController::class);

use App\Http\Controllers\MataPelajaranController;

// Mata Pelajaran management
Route::resource('mata-pelajaran', MataPelajaranController::class);

use App\Http\Controllers\JenisPenilaianController;

// jenis penilaian management
Route::resource('jenis-penilaian', JenisPenilaianController::class);

use App\Http\Controllers\TokenController;

// Token management
Route::resource('tokens', TokenController::class);



