<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Question;

class StudentAnswer extends Model {
    protected $fillable = [
        'student_id',
        'assignment_id',
        'question_id',
        'answer_text',
        'selected_option_id',
        'essay_photo_path',
        'score'
    ];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption() {
        return $this->belongsTo(MultipleChoiceOption::class, 'selected_option_id');
    }
}