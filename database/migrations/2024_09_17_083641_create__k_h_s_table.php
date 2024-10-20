<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('_k_h_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade'); // Foreign key from siswa
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->foreignId('jenis_penilaian_id')->constrained('jenis_penilaians')->onDelete('cascade'); // Foreign key from Jenis Penilaian
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade'); // Foreign key from Jenis Penilaian
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_k_h_s');
    }
};
