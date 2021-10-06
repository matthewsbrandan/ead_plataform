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
        $this->adminOnly();
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
    public function edit($id){
        $this->adminOnly();
        if(!$category = Category::whereId($id)->first()) return redirect()->back()->with(
            'message', 'Categoria não encontrada'
        );
        return view('category.edit',['category' => $category]);
    }
    public function store(Request $request, $id = null){
        $this->adminOnly();
        $data = [
            'title',
            'slug',
            'description',
            'wallpaper',
        ];
    }
}