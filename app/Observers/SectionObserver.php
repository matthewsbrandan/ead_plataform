<?php

namespace App\Observers;

use App\Models\Section;

class SectionObserver
{
    public function created(Section $section){
        if($section->section_id){
            $arrBreadcrumbs = $section->fatherSection->array_breadcrumbs();
            $arrBreadcrumbs[]= $section->fatherSection->id;
            
            $index = $section->fatherSection->sections->count();
            $index+= $section->fatherSection->lessons->count();

            $data = [
                'depth' => $section->fatherSection->depth+1,
                'breadcrumbs' => implode(',', $arrBreadcrumbs),
                'index' => $index-1
            ];
            $section->update($data);
        }else{
            $index = $section->course->sections->where('depth', 0)->count();
            $index+= $section->course->lessons->where('depth', 0)->count();
            $section->update(['index' => $index-1]);
        }
    }

    public function updated(Section $section){
        //
    }

    public function deleted(Section $section){
        if($section->depth == 0){
            $sections = $section->course->sections
                ->where('depth',0)
                ->where('index','>',$section->index);
            $lessons = $section->course->lessons
                ->where('depth',0)
                ->where('index','>',$section->index);    
        }else{
            $sections = $section->fatherSection->sections
                ->where('index','>',$section->index);
            $lessons = $section->fatherSection->lessons
                ->where('index','>',$section->index);
        }

        foreach($sections as $row){
            $row->update(['index' => $row->index-1]);
        }
        foreach($lessons as $row){
            $row->update(['index' => $row->index-1]);
        }
    }
}
