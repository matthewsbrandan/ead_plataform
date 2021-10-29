<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class ClassController extends Controller
{
    public function index($slug){
        if(!$course = Course::with(['students' => function($query){
            $query->where('user_id', auth()->user()->id);
        }])->whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );
        
        return view('class.index',[
            'course' => $course
        ]);
    }
    public function show($slug, $lesson_id = null){
        if(!$course = Course::with(['sections' => function($query){
            $query->where('depth', 0);
        }, 'lessons' => function($query){
            $query->where('depth', 0);
        }, 'studentsPivot' => function($query){
            $query->where('user_id', auth()->user()->id);
        }])->whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );


        $student = $course->studentsPivot->first();
        if(!$student) return redirect()->route('class.index',[
            'slug' => $slug
        ])->with(
            'message',
            'Você ainda não ingressou neste curso, matricule-se para ter acesso as aulas.'
        );

        $classes = $course->classes();
        if(!$currentLesson = $student->current_lesson){
            if(!$currentLesson = $this->findFirstLesson($classes)) return redirect()->back()->with('message','Este curso ainda não possui aulas!');
        }

        return view('class.show',[
            'course' => $course,
            'currentLesson' => $currentLesson,
            'classes' => $classes
        ]);
    }
    public function chat($slug){
        dd('Aqui');
    }
    public function outhers($slug){
        dd('Aqui');
    }
    protected function findFirstLesson($classes){
        foreach($classes as $class){
            if($class['type'] == 'lesson') return $class['data'];
            elseif($class['data']['classes'] && count($class['data']['classes'])){
                $firstLesson = $this->findFirstLesson($class['data']['classes']);
                if($firstLesson) return $firstLesson;
            }
        }
        return null;
    }
}
