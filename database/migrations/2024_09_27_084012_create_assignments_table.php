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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade'); // Foreign key from Mata Pelajaran
            $table->foreignId('jenis_penilaian_id')->constrained('jenis_penilaians')->onDelete('cascade'); // Foreign key from Jenis Penilaian
            $table->foreignId('token_id')->constrained('tokens')->onDelete('cascade'); // Foreign key from Jenis Penilaian
            $table->foreignId('enroll_class_id')->constrained('enroll_class')->onDelete('cascade'); // Foreign key from Jenis Penilaian
            $table->string('code_assignment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
