<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\UserCourse;

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
        if($currentLesson->type != 'video'){
            $userLesson = new UserLessonController();
            $request = new Request();
            $request->merge([
                'lesson_id' => $currentLesson->id,
                'course_id' => $course->id
            ]);
            $userLesson->toView($request, $course->slug, false);
        }

        $chatController = new ChatController();
        $response = ($chatController->chatLesson($currentLesson->id))->content();
        $chatResponse = json_decode($response);
        $currentLesson->questions = $chatResponse->response;
        $currentLesson->breadcrumbs_formatted = explode(',',$currentLesson->breadcrumbs);

        return view('class.show',[
            'course' => $course,
            'currentLesson' => $currentLesson,
            'classes' => $classes,
            'student' => $course->student()
        ]);
    }
    public function chat($slug){
        dd('Aqui');
    }
    public function outhers($slug){
        $courses = Course::whereNotNull('published_at')
            ->inRandomOrder()
            ->take(5)
            ->get();
        return view('class.outhers',['courses' => $courses]);
    }
    public function subscribe($slug){
        if(!$course = Course::with(['students' => function($query){
            $query->where('user_id', auth()->user()->id);
        }])->whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );
        
        if($course->students->first()) return redirect()->back()->with(
            'message',
            'Você já está matriculado neste curso'
        );

        UserCourse::create([
            'user_id' => auth()->user()->id,
            'course_id' => $course->id,
        ]);

        return redirect()->route('class.show',['slug' => $course->slug])->with(
            'message',
            "Bem vindo ao curso ". $course->title
        );
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