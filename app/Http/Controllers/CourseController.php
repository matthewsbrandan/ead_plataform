<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    protected $take;

    public function __construct(){
        $this->take = 10;
    }
    #region SHOW
    public function index($skip = 0){
        return view('course.index');
    }
    public function create(){        
        $this->teacherOnly();
        
        $categories = Category::where('slug','!=','outros')->get();
        $categoryOuthers = Category::whereSlug('outros')->first();

        return view('course.create',[
            'categories' => $categories,
            'categoryOuthers' => $categoryOuthers
        ]);
    }
    public function mine($skip = 0){
        $this->teacherOnly();
        $courses = Course::with('category')->whereUserId(auth()->user()->id)
            ->take($this->take)
            ->skip($skip)
            ->orderBy('id','DESC')
            ->get();

        if($skip > 0) return response()->json([
            'courses' => $courses,
        ]);
        return view('course.mine', [
            'courses' => $courses,
        ]);    
    }
    public function edit($id){
        $this->teacherOnly();
        if(!$course = Course::whereId($id)
            ->whereUserId(auth()->user()->id)
            ->first()
        ) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );

        dd($course->toArray());
    }
    #endregion SHOW
    #region STORE
    public function store(Request $request){
        $this->teacherOnly();

        $slug = $this->handleCourseSlug($request->title);

        $path = "uploads/courses/";
        ['names' => $names,'errors' => $errors] = $this->uploadImages([$request->file('wallpaper')],$path);

        if(count($errors) > 0 || count($names) == 0) return redirect()->back()->with(
            'error-new-category', 'Houve um erro ao fazer o upload da imagem'
        );

        $wallpaper = $names[0];

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'wallpaper' => $wallpaper,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id,
            'slug' => $slug,
        ];

        Course::create($data);

        return redirect()->route('course.mine')->with(
            "message",
            "Curso criado com sucesso!<br/>Adicione aulas para ele e publique quando quiser!"
        );
    }
    public function publish($id){
        $this->teacherOnly();

        if(!$course = Course::whereId($id)
            ->whereUserId(auth()->user()->id)
            ->first()
        ) return redirect()->back()->with(
            'message',
            'Curso não encontrado'
        );

        if($course->published_at) return redirect()->back()->with(
            'message',
            'Este curso já foi publicado'
        );

        $course->update(['published_at' => Carbon::now()]);
        return redirect()->route('course.mine')->with(
            'message',
            'Curso publicado com sucesso'
        );
    }
    #endregion STORE
    #region LOCAL FUNCTIONS
    protected function handleCourseSlug($title){
        $slug = $this->generateSlug($title);

        $slugs = Course::select('slug')
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