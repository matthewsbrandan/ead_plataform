<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index($slug){
        if(!$course = Course::whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );
        dd($course->toArray());
    }
    public function create($slug){
        $this->teacherOnly();
        if(!$course = Course::whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );
        dd($course->toArray());
    }
    public function store($slug){
        $this->teacherOnly();
        if(!$course = Course::whereSlug($slug)->first()) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );
        dd($course->toArray());
    }
}