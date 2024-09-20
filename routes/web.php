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
use App\Http\Controllers\AssignmentController as ControllersAssignmentController;

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
Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');

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
Route::post('kelas_siswas/import', [KelasSiswaController::class, 'import'])->name('kelas_siswas.import');



use App\Http\Controllers\GuruPelajaranController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PenilaianController;

// Kelas Siswa management
Route::resource('guru_pelajarans', GuruPelajaranController::class);
Route::get('/guru_pelajarans-import', [GuruPelajaranController::class, 'import'])->name('guru_pelajarans.import');

// KHS manageement
Route::resource('khs', KHSController::class);

Route::resource('assignments', ControllersAssignmentController::class);

use App\Http\Controllers\SoalController;

Route::resource('soals', SoalController::class);

Route::resource('penilaians', PenilaianController::class);

Route::resource('pilihan_gandas', App\Http\Controllers\PilihanGandaController::class);

use App\Http\Controllers\LembarJawabanController;

Route::get('/lembar-jawaban', [LembarJawabanController::class, 'index'])->name('lembar_jawaban.index');
Route::get('/lembar-jawaban/{assignmentId}/{siswaId}', [LembarJawabanController::class, 'detail'])->name('lembar_jawaban.detail');
Route::post('/lembar-jawaban/{lembarJawabanId}/update-score', [LembarJawabanController::class, 'updateScore'])->name('lembar_jawaban.update_score');

