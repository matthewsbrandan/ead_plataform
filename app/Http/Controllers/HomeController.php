<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\UserCourse;

class HomeController extends Controller
{
    public function index(){
        $coursesCompleted = UserCourse::whereUserId(auth()->user()->id)->whereCompleted(true)->orderBy('updated_at','desc')->get();
        return view('home.index', ['coursesCompleted' => $coursesCompleted]);
    }
    public function welcome(){
        $categories = Category::where('slug','!=','outros')
            ->orderBy('num_courses','desc')
            ->take(4)
            ->get();
        return view('welcome',['categories' => $categories]);
    }
}