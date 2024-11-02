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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('assignment_id')->constrained();
            $table->foreignId('question_id')->constrained();
            $table->text('answer_text')->nullable(); // Untuk essay
            $table->foreignId('selected_option_id')->nullable()->constrained('multiple_choice_options'); // Untuk pilgan
            $table->string('essay_photo_path')->nullable(); // Path untuk foto jawaban essay
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
