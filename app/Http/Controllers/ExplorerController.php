<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class ExplorerController extends Controller
{
    protected $take;

    public function __construct(){
        $this->take = 20;
    }
    public function index($search = null){
        $courses = Course::whereNotNull('published_at')
            ->inRandomOrder()
            ->take($this->take)
            ->get();


        if(auth()->user()) return view('explorer.index', ['courses' => $courses]);
        return view('explorer.public', ['courses' => $courses]);
    }
}