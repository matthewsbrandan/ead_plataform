<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\UserCourse;

class CourseObserver
{
    public function created(Course $course){
        $course->category->update([
            'num_courses' => $course->category->courses->count()
        ]);
        
        UserCourse::create([
            'user_id' => $course->user_id,
            'course_id' => $course->id,
        ]);
    }

    public function updated(Course $course){
    }

    public function deleted(Course $course){
    }
}
