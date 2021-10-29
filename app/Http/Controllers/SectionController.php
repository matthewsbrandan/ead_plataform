<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Course;

class SectionController extends Controller
{
    public function store(Request $request){
        $this->teacherOnly();
        
        if(!$course = Course::whereId($request->course_id)
            ->whereUserId(auth()->user()->id)
            ->first()
        ) return redirect()->back()->with(
            'message', 'Curso não encontrado, ou você não possui permissão para alterá-lo'
        );

        $data = [
            'title' =>  $request->title,
            'course_id' =>  $request->course_id,
        ];
        if(isset($request->section_id) && $request->section_id) $data+= ['section_id' =>  $request->section_id];

        Section::create($data);

        return redirect()->back()->with('message', 'Seção criada com sucesso');
    }
    public function delete($id){
        $this->teacherOnly();

        if(!$section = Section::with('course')->whereId($id)->first()) return redirect()->back()->with(
            'message', 'Seção não encontrada'
        );

        if($section->course->user_id != auth()->user()->id) return redirect()->back()->with(
            'message', 'Você não tem permissão para excluir seções deste grupo'
        );

        $section->delete();
        
        return redirect()->back()->with('message', 'Seção excluída com sucesso!');
    }
}