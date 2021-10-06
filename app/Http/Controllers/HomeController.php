<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }
    public function welcome(){
        $categories = Category::where('slug','!=','outros')
            ->orderBy('num_courses','desc')
            ->take(4)
            ->get();
        return view('welcome',['categories' => $categories]);
    }
}