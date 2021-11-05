<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'current_lesson_id',
        'progress',
        'completed',
        'rating',
    ];

    public function current_lesson(){
        return $this->belongsTo(Lesson::class, 'current_lesson_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}