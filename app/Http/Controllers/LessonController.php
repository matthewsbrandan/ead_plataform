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
    public function edit($slug, $id){
        $this->teacherOnly();
        if(!$course = Course::with(['lessons' => function($query) use ($id){
            $query->where('id', $id);
        }])->whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );

        if(!$course->lessons->first()) return redirect()->back()->with(
            'message',
            'Aula não encontrada'
        );

        $lesson = $course->lessons->first();
        
        return view('lesson.create.class', [
            'course' => $course,
            'section' => $lesson->section,
            'type' => $lesson->type,
            'lesson' => $lesson
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

        $id = $request->id ?? null;

        $type = $request->type;
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $type,
            'course_id' => $request->course_id,
            'user_id' => auth()->user()->id,
        ];

        if($type == 'video'){
            $data+=['url' => $request->url];
            if($request->duration) $data+=['duration' => $request->duration];
        }
        if($type == 'article') $data+=[
            'content' => $request->content,
            'duration' => $this->handleDurationArticle($request->content)
        ];
        if($type == 'archive'){
            // ADICIONAR FUNÇÃO DE UPLOAD, E NESTA FUNÇÃO ENVEZ DE O LINK TER O TEXTO DE
            // LINK EXTERNO, COLOCAR O TEXTO DE DOWNLOAD
            $countArchiveLink = count($request->link_url);
            $archives = [];
            for($i = 0; $i < $countArchiveLink; $i++){
                $archives[] = [
                    'link' => $request->link_url[$i],
                    'description' => $request->link_description[$i]
                ];
            }
            $data+=['content' => json_encode($archives)];
        }
        if(isset($request->section_id) && $request->section_id) $data+= [
            'section_id' => $request->section_id
        ];

        Lesson::updateOrCreate(['id' => $id], $data);
        return redirect()->route('lesson.create',['slug' => $course->slug]);
    }
    public function delete($slug, $id){
        $this->teacherOnly();
        if(!$course = Course::with(['lessons' => function($query) use ($id){
            $query->where('id', $id);
        }])->whereSlug($slug)->whereUserId(auth()->user()->id)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );

        if(!$course->lessons->first()) return redirect()->back()->with(
            'message',
            'Aula não encontrada'
        );

        $lesson = $course->lessons->first();
        $lesson->delete();

        return redirect()->route('lesson.create',['slug' => $course->slug])->with(
            'message',
            'Aula excluída com sucesso!'
        );
    }
    public function handleDurationArticle($content){
        $cleanContent = trim(strip_tags($content));
        $seconds =  (int) ceil((str_word_count($cleanContent) / 200)*60);
        return $seconds;
    }
}