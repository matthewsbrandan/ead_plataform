<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\UserCourse;

class CourseObserver
{
    /**
     * Handle the Course "created" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function created(Course $course){
        $course->category->update([
            'num_courses' => $course->category->courses->count()
        ]);
        
        UserCourse::create([
            'user_id' => $course->user_id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Handle the Course "updated" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function updated(Course $course)
    {
        //
    }

    /**
     * Handle the Course "deleted" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function deleted(Course $course)
    {
        //
    }

}
