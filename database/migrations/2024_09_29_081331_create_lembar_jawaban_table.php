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
        Schema::create('lembar_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->foreignId('soal_id')->constrained('soals')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->string('jawaban_siswa'); // Foreign key from Mata Pelajaran
            $table->integer('score')->nullable(); // Foreign key from Mata Pelajaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembar_jawaban');
    }
};
