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
    public function store(Request $request){
        $this->adminOnly();

        $category = null;
        if(isset($request->id) && $request->id) if(
            !$category = Category::whereId($request->id)->first()
        ) return redirect()->back()->with(
            'message', 'Categoria não encontrada'
        );

        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];
        
        if($category == null){
            $slug = $this->handleCategorySlug($request->title);
            $data+=['slug' => $slug];
        }

        if($request->file('wallpaper')){
            $path = "uploads/categories/";
            ['names' => $names,'errors' => $errors] = $this->uploadImages([$request->file('wallpaper')],$path);
    
            if(count($errors) > 0 || count($names) == 0) return redirect()->back()->with(
                'error-new-category', 'Houve um erro ao fazer o upload da imagem'
            );

            $wallpaper = $names[0];
            $data+= ['wallpaper' => $wallpaper];
        }
        

        if($category == null) Category::create($data);
        else $category->update($data);

        return redirect()->route('category.index')->with(
            'message',$category == null ?
            'Categoria cadastrada com sucesso!':'Categoria editada com sucesso'
        );
    }
    #region LOCAL FUNCTIONS
    protected function handleCategorySlug($title){
        $slug = $this->generateSlug($title);

        $slugs = Category::select('slug')
            ->where('slug','like',"$slug%")
            ->get()
            ->toArray();

        $slugs = array_column($slugs, 'slug');
        $increment = "";
        $count = 0;
        while(in_array($slug.$increment, $slugs)){
            $count++;
            $increment = "_$count";
        }
        return $slug.$increment;
    }
    #endregion LOCAL FUNCTIONS
}