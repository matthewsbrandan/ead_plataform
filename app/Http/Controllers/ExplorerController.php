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
        $exclude_ids = [];
        $courseRecommendeds = collect([]);
        if(auth()->user()) [$courseRecommendeds, $exclude_ids] = $this->recommended($exclude_ids);

        $countRecommendeds = $courseRecommendeds->count();
        if($countRecommendeds < $this->take) $courses = Course::whereNotNull('published_at')
            ->whereNotIn('id',$exclude_ids)
            ->when(auth()->user(), function($query){
                return $query->where('user_id', '!=', auth()->user()->id);
            })
            ->inRandomOrder()
            ->take($this->take - $countRecommendeds)
            ->get();

        if($countRecommendeds > 0) $courses = $courseRecommendeds->merge($courses);
        if(auth()->user()) return view('explorer.index', ['courses' => $courses]);
        return view('explorer.public', ['courses' => $courses]);
    }
    public function recommended($exclude_ids){
        /** A RECOMENDAÇÃO DE CURSOS SE BASEIA NOS CURSOS EM QUE VOCÊ JÁ ESTÁ ESCRITO, ELA UTILIZA COMO MÉTODO DE COMPARAÇÃO:
         *  - CURSOS DO MESMO CRIADOR
         *  - CURSOS DA MESMA CATEGORIA
         *  - CURSOS COM AS MESMAS PALAVRAS CHAVES
         *  E AO FINAL DA FILTRAGEM O RESULTADO É FILTRADO BASEADO EM SEU NÍVEL DE COMPATIBILIDADE */
        $keywords = [];
        $myCourses = auth()->user()->courses()
            ->where('courses.user_id','!=',auth()->user()->id)
            ->select('courses.id','courses.keywords','courses.category_id','courses.user_id','courses.rating')
            ->get()
            ->map(function($course) use ($keywords){
                $keys = $course->getKeywordsFormatted();
                foreach($keys as $key){
                    if(!in_array($key, $keywords)) $keywords[] = $key;
                }
                return $course;
            });

        $exclude_ids = [
            ...$exclude_ids,
            ...array_column($myCourses->toArray(), 'id')
        ];

        $filters = (object)[
            'keywords' => $keywords,
            'category_ids' => array_column($myCourses->toArray(), 'category_id'),
            'user_ids' => array_column($myCourses->toArray(), 'user_id')
        ];

        $recommended = Course::whereNotNull('published_at')
            ->whereNotIn('id',$exclude_ids)
            ->where('user_id', '!=', auth()->user()->id)
            ->where(function($query) use ($filters){
              return $query->whereIn('user_id', $filters->user_ids)
                ->orWhereIn('category_id', $filters->category_ids)
                ->when(count($filters->keywords) > 0, function($q) use ($filters){
                    foreach($filters->keywords as $key){
                        $q->orWhere('keywords','like',"%$key%");
                    }
                    return $q;
                });
            })
            ->take($this->take)
            ->get()
            ->map(function($rec) use ($filters){
                $rec->match_point = 0;
                if(in_array($rec->user_id, $filters->user_ids)) $rec->match_point++;
                if(in_array($rec->category_id, $filters->category_ids)) $rec->match_point++;
                foreach($filters->keywords as $key){
                    if($req->where('keywords','like',"%$key%")->first()){
                        $rec->match_point++;
                        break;
                    }
                }
                return $rec;
            })->sortBy([
                ['match_point', 'desc'],
                ['rating', 'desc']
            ]);

        $exclude_ids = [
            ...$exclude_ids,
            ...array_column($recommended->toArray(), 'id')
        ];

        return [
            $recommended,
            $exclude_ids
        ];
    }
}