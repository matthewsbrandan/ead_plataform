<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $take;
    public function __construct(){
        $this->take = 20;
    }
    public function index($skip = 0, $responseInArray = false){
        $categories = Category::orderBy('num_courses','desc')
            ->skip($skip)
            ->take($this->take)
            ->get();

        $total = Category::count();

        if($responseInArray) return [
            'result' => true,
            'response' => $categories
        ];

        return view('category.index',['categories' => $categories, 'total' => $total]);
    }
    public function create(){
        // return view('category.create');
    }
    public function edit(){
        // return view('category.edit');
    }
    public function store($id = null){
        // $data = [];
    }
}