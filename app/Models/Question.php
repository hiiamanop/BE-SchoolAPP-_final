<?php

// app/Models/Question.php

use App\Models\Assignment;
use App\Models\MultipleChoiceOption;
use App\Models\StudentAnswer;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $fillable = [
        'assignment_id',
        'question_text',
        'question_type',
        'points'
    ];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function options() {
        return $this->hasMany(MultipleChoiceOption::class);
    }

    public function studentAnswers() {
        return $this->hasMany(StudentAnswer::class);
    }
}
