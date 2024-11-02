<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/AssignmentScore.php
class AssignmentScore extends Model {
    protected $fillable = [
        'student_id',
        'assignment_id',
        'total_score',
        'teacher_notes'
    ];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }
}
