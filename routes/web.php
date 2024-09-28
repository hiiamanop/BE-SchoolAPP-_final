<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruPelajaranController;
use App\Http\Controllers\JenisPenilaianController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasSiswaController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\LembarJawabanController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
})->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

use App\Http\Middleware\RoleMiddleware;

// Admin-only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('admins', AdminController::class);
    Route::resource('gurus', GuruController::class);
    Route::post('gurus/import', [GuruController::class, 'import'])->name('gurus.import');
    Route::resource('siswas', SiswaController::class);
    Route::post('/upload', [SiswaController::class, 'import1'])->name('siswas.upload');
    Route::resource('bukus', BukuController::class);
    Route::post('/bukus/import', [BukuController::class, 'import'])->name('bukus.import');
    Route::resource('kategori_buku', KategoriBukuController::class);
    Route::resource('kelas', KelasController::class);
    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');
    Route::resource('mata-pelajaran', MataPelajaranController::class);
    Route::post('/mata-pelajaran/import', [MataPelajaranController::class, 'import'])->name('mata-pelajaran.import');
    Route::resource('jenis-penilaian', JenisPenilaianController::class);
    Route::resource('tokens', TokenController::class);
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::resource('kelas_siswas', KelasSiswaController::class);
    Route::post('kelas_siswas/import', [KelasSiswaController::class, 'import'])->name('kelas_siswas.import');
    Route::resource('guru_pelajarans', GuruPelajaranController::class);
    Route::post('guru_pelajarans/import', [GuruPelajaranController::class, 'import'])->name('guru_pelajarans.import');
    Route::resource('khs', KHSController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('soals', SoalController::class);
    Route::resource('penilaians', PenilaianController::class);
    Route::resource('pilihan_gandas', App\Http\Controllers\PilihanGandaController::class);
    Route::get('/lembar-jawaban', [LembarJawabanController::class, 'index'])->name('lembar_jawaban.index');
    Route::get('/lembar-jawaban/{assignmentId}/{siswaId}', [LembarJawabanController::class, 'detail'])->name('lembar_jawaban.detail');
    Route::post('/lembar-jawaban/{lembarJawabanId}/update-score', [LembarJawabanController::class, 'updateScore'])->name('lembar_jawaban.update_score');
});

// Guru-only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin,guru'])->group(function () {
    Route::resource('khs', KHSController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('soals', SoalController::class);
    Route::resource('penilaians', PenilaianController::class);
    Route::resource('pilihan_gandas', App\Http\Controllers\PilihanGandaController::class);
    Route::get('/lembar-jawaban', [LembarJawabanController::class, 'index'])->name('lembar_jawaban.index');
    Route::get('/lembar-jawaban/{assignmentId}/{siswaId}', [LembarJawabanController::class, 'detail'])->name('lembar_jawaban.detail');
    Route::post('/lembar-jawaban/{lembarJawabanId}/update-score', [LembarJawabanController::class, 'updateScore'])->name('lembar_jawaban.update_score');
});
