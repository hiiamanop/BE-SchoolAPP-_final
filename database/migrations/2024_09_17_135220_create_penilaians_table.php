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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->integer('jumlah_soal');
            $table->integer('max_score');
            $table->integer('pilgan_score')->nullable();
            $table->integer('essay_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
