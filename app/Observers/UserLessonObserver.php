<?php

namespace App\Observers;

use App\Models\UserLesson;

class UserLessonObserver
{
    public function created(UserLesson $userLesson){
        $num_views = UserLesson::whereLessonId($userLesson->lesson_id)
            ->whereViewed(true)
            ->count();
        $rating = UserLesson::whereLessonId($userLesson->lesson_id)
            ->groupBy('lesson_id')
            ->avg('rating');
        $userLesson->lesson->update([
            'num_views' => $num_views,
            'rating' => $rating,
        ]);
    }

    public function updated(UserLesson $userLesson){
        $num_views = UserLesson::whereLessonId($userLesson->lesson_id)
            ->whereViewed(true)
            ->count();
        $rating = UserLesson::whereLessonId($userLesson->lesson_id)
            ->groupBy('lesson_id')
            ->avg('rating');
        $userLesson->lesson->update([
            'num_views' => $num_views,
            'rating' => $rating,
        ]);
    }

    public function deleted(UserLesson $userLesson){
        //
    }
}
