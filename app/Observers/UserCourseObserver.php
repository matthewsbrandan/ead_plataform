<?php

namespace App\Observers;

use App\Models\UserCourse;

class UserCourseObserver
{
    /**
     * Handle the UserCourse "created" event.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return void
     */
    public function created(UserCourse $userCourse){
        $userCourse->course->update([
            'num_students' => $userCourse->course->students->count(),
        ]);
    }

    /**
     * Handle the UserCourse "updated" event.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return void
     */
    public function updated(UserCourse $userCourse){
        $rating = UserCourse::whereCourseId($userCourse->course_id)
            ->groupBy('course_id')
            ->avg('rating');
        $userCourse->course->update(['rating' => $rating]);
    }

    /**
     * Handle the UserCourse "deleted" event.
     *
     * @param  \App\Models\UserCourse  $userCourse
     * @return void
     */
    public function deleted(UserCourse $userCourse){
        $userCourse->course->update([
            'num_students' => $userCourse->course->students->count(),
        ]);
    }
}
