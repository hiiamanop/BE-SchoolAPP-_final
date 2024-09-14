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
Route::post('gurus/import', [GuruController::class, 'import'])->name('gurus.import');

// Siswa management
Route::resource('siswas', SiswaController::class);

// Route for importing Siswa from an Excel file
Route::post('/upload', [SiswaController::class, 'import1'])->name('siswas.upload');



use App\Http\Controllers\BukuController;

// Buku management
Route::resource('bukus', BukuController::class);
Route::post('/bukus/import', [BukuController::class, 'import'])->name('bukus.import');


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
use App\Http\Controllers\TahunAjaranController;

// jenis penilaian management
Route::resource('jenis-penilaian', JenisPenilaianController::class);

use App\Http\Controllers\TokenController;

// Token management
Route::resource('tokens', TokenController::class);

// Tahun Ajaran management
Route::resource('tahun-ajaran', TahunAjaranController::class);


use App\Http\Controllers\KelasSiswaController;

// Kelas Siswa management
Route::resource('kelas_siswas', KelasSiswaController::class);
// Add this custom route for creating a KelasSiswa with a kelasId parameter
Route::get('kelas_siswas/create/{kelasId}', [KelasSiswaController::class, 'create'])->name('kelas_siswas.create');
Route::delete('kelas_siswas/{id}', [KelasSiswaController::class, 'destroy'])->name('kelas_siswas.destroy');
