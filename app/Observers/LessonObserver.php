<?php

namespace App\Observers;

use App\Models\Lesson;

class LessonObserver
{
    public function created(Lesson $lesson){
        if($lesson->section_id){
            $arrBreadcrumbs = $lesson->section->array_breadcrumbs();
            $arrBreadcrumbs[]= $lesson->section->id;
            
            $index = $lesson->section->sections->count();
            $index+= $lesson->section->lessons->count();

            $data = [
                'depth' => $lesson->section->depth+1,
                'breadcrumbs' => implode(',', $arrBreadcrumbs),
                'index' => $index-1
            ];
            $lesson->update($data);
        }else{
            $index = $lesson->course->sections->where('depth', 0)->count();
            $index+= $lesson->course->lessons->where('depth', 0)->count();
            $lesson->update(['index' => $index-1]);
        }
        $newDuration = $lesson->course->duration->addSecond($lesson->getDurationInSeconds());
        $lesson->course->update([
            'duration' => $newDuration,
            'num_classes' => $lesson->course->lessons->count()
        ]);

        $lesson->course->updateLessonRealIndex();
    }

    public function updated(Lesson $lesson){
        $seconds = 0;
        foreach($lesson->course->lessons as $target){
            $seconds+= $target->getDurationInSeconds();
        }
        $lesson->course->update([
            'duration' => $seconds,
        ]);
    }

    public function deleted(Lesson $lesson){
        if($lesson->depth == 0){
            $sections = $lesson->course->sections
                ->where('depth',0)
                ->where('index','>',$lesson->index);
            $lessons = $lesson->course->lessons
                ->where('depth',0)
                ->where('index','>',$lesson->index);    
        }else{
            $sections = $lesson->section->sections
                ->where('index','>',$lesson->index);
            $lessons = $lesson->section->lessons
                ->where('index','>',$lesson->index);
        }

        foreach($sections as $row){
            $row->update(['index' => $row->index-1]);
        }
        foreach($lessons as $row){
            $row->update(['index' => $row->index-1]);
        }

        $seconds = 0;
        foreach($lesson->course->lessons as $target){
            $seconds+= $target->getDurationInSeconds();
        }
        $lesson->course->update([
            'duration' => $seconds,
            'num_classes' => $lesson->course->lessons->count()
        ]);

        $lesson->course->updateLessonRealIndex();
    }
}