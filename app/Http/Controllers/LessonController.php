<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function create($slug){
        $this->teacherOnly();
        if(!$course = Course::with(['sections' => function($query){
            $query->where('depth', 0);
        }, 'lessons' => function($query){
            $query->where('depth', 0);
        }])->whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );

        $classes = $course->classes();

        return view('lesson.create.index', ['course' => $course, 'classes' => $classes]);
    }
    public function class($slug, $section_id = null, $type = 'video'){
        $this->teacherOnly();
        if(!$course = Course::whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );

        $section = null;
        if($section_id) $section = Section::whereId($section_id)->first();
        
        return view('lesson.create.class', [
            'course' => $course,
            'section' => $section,
            'type' => $type
        ]);
    }
    public function store(Request $request, $slug){
        $this->teacherOnly();
        if(!$course = Course::whereSlug($slug)
            ->whereUserId(auth()->user()->id)
            ->first()
        ) return redirect()->back()->with(
            'message',
            'Curso não encontrado, ou sem permissão para adicionar aulas'
        );

        $type = $request->type;
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $type,
            'course_id' => $request->course_id,
            'user_id' => auth()->user()->id,
        ];

        if($type == 'video') $data+=['url' => $request->url];
        if($type == 'article') $data+=['content' => $request->content];
        if($type == 'archive'){
            // ADICIONAR FUNÇÃO DE UPLOAD, E NESTA FUNÇÃO ENVEZ DE O LINK TER O TEXTO DE
            // LINK EXTERNO, COLOCAR O TEXTO DE DOWNLOAD
            $countArchiveLink = count($request->link_url);
            $html = "<div class=\"list-archive\">";
            for($i = 0; $i < $countArchiveLink; $i++){
                $html.= "<div class=\"archive-item\">";
                $html.= "<a href=\"{$request->link_url[$i]}\">Link Externo</a>";
                $html.= "<p>{$request->link_description[$i]}</p>";
                $html.= "</div>";
            }
            $html.="</div>";
            $data+=['content' => $html];
        }
        if(isset($request->section_id) && $request->section_id) $data+= [
            'section_id' => $request->section_id
        ];

        // TODO -- DURATION --

        Lesson::create($data);
        return redirect()->route('lesson.create',['slug' => $course->slug]);
    }
}