<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'course_id',
        'rating',
        'viewed',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lesson(){
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}