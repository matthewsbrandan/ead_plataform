<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'num_answers',
        'depth',
        'breadcrumbs',
        'is_course',
        'lesson_id', // EXISTIRÁ QUANDO FOR CHAT RELACIONADO A AULA
        'course_id', // EXISTIRÁ QUANDO FOR CHAT DIRETO COM PROFESSOR
        'user_id',
        'answer_id',
    ];

    public function answers(){
        return $this->hasMany(Chat::class, 'answer_id');
    }
    public function father(){
        return $this->belongsTo(Chat::class, 'answer_id');
    }
    public function lesson(){
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }
}