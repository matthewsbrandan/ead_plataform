<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\UserCourse;

class HomeController extends Controller
{
    public function index(){
        $temp = auth()->user()->coursesPivot()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $userCourse = [];
        foreach($temp as $course){
            if($course->course->user_id != auth()->user()->id) $userCourse[]= $course;
        }

        $temp = UserCourse::whereUserId(auth()->user()->id)->whereCompleted(true)->orderBy('updated_at','desc')->get();
        $coursesCompleted = [];
        foreach($temp as $course){
            if($course->course->user_id != auth()->user()->id) $coursesCompleted[]= $course;
        }

        return view('home.index', [
            'userCourse' => $userCourse,
            'coursesCompleted' => $coursesCompleted
        ]);
    }
    public function welcome(){
        $categories = Category::where('slug','!=','outros')
            ->orderBy('num_courses','desc')
            ->take(4)
            ->get();
        return view('welcome',['categories' => $categories]);
    }
}