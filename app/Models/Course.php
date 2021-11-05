<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'wallpaper',
        'about',
        'keywords',
        'presentation_url',
        'duration',
        'num_classes',
        'num_students',
        'raiting',
        'user_id',
        'category_id',
        'published_at'
    ];
    protected $dates = [
        'published_at',
        'duration',
    ];

    #region RELATIONSHIPS
    public function teacher(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function students(){
        return $this->belongsToMany(User::class, 'user_courses', 'course_id', 'user_id');
    }
    public function studentsPivot(){
        return $this->hasMany(UserCourse::class, 'course_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function sections(){
        return $this->hasMany(Section::class, 'course_id');
    }
    public function lessons(){
        return $this->hasMany(Lesson::class, 'course_id');
    }
    public function classes(){
        $classes = [];
        foreach($this->sections as $section){
            $section->classes = [];
            if($section->sections->count() > 0 || $section->lessons->count() > 0){
                $section->classes = $this->handleSubClasses($section);
            }

            $classes[]= [
                'index' => $section->index,
                'type' => 'section',
                'data' => $section
            ];
        }
        foreach($this->lessons as $lesson){
            $classes[]= [
                'index' => $lesson->index,
                'type' => 'lesson',
                'data' => $lesson
            ];
        }

        $classes = $this->array_orderby($classes, 'index');
        return $classes;
    }
    public function student(){
        return $this->studentsPivot->where('user_id', auth()->user()->id)->first();
    }
    #endregion RELATIONSHIPS

    public function updateLessonRealIndex($classes = null, $real_index = 0){
        if(!$classes) $classes = $this->classes();

        foreach($classes as $class){
            if($class['type'] == 'lesson'){
                $class['data']->update(['real_index' => $real_index]);
                $real_index++;
            }
            elseif(count($class['data']->classes) > 0){
                $real_index = $this->updateLessonRealIndex($class['data']->classes, $real_index);
            }
        }
        return $real_index;
    }
    public function formatDuration(){
        $strDate = "";
        $hours = $this->duration->format('H');
        $minutes = $this->duration->format('i');
        if($hours > 0) $strDate = $hours."h ";
        if($minutes > 0) $strDate.= $minutes."min";
        if(strlen($strDate) == 0) $strDate = null;

        return $strDate;
    }
    public function durationInMinutes(){
        $hours = $this->duration->format('H');
        $minutes = $this->duration->format('i');
        return ($hours*60) + $minutes;
    }
    public function getDurationInSeconds(){
        $hours = $this->duration->format('H');
        $minutes = $this->duration->format('i');
        $seconds = $this->duration->format('s');
        return ($hours * 60 * 60) + ($minutes * 60) + $seconds;
    }
    public function fillQuality(){
        /** PONTUAÇÃO
         * 'title' +  'description' +  'wallpaper' = 30 (obrigatórios)
         * 'about' = 20
         * 'keywords' = 10
         * 'presentation_url' = 20
         * 'duration' = 10
         * 'num_classes' = 10        
         */
        $points = 30;
        $missions = [];
        if($this->about) $points+=20;
        else $missions[]= "Preencha a sessão 'sobre' em seu curso para conseguir mais 20 pontos";

        if($this->keywords) $points+=10;
        else $missions[]= "Adicione palavras chaves para encontrarmos seu curso mais facilmente, e ganhe mais 10 pontos";
        
        if($this->presentation_url) $points+=20;
        else $missions[]= "Adicione um vídeo de apresentação para ganhar mais 20 pontos";
    
        $minutes = $this->durationInMinutes();
        if($minutes > 10) $points+=10;
        else $missions[]= "Seu curso está com $minutes minuto(s) até agora, quando chegar a 10min terá mais 10 pontos como recompensa";

        if($this->num_classes > 2) $points+=10;
        else $missions[]= "Adicione pelo menos 2 aulas ao seu curso para conseguir mais 10 pontos";

        return (object)[
            'points' => $points,
            'missions' => $missions
        ];
    }

    #region LOCAL FUNCTIONS
    protected function array_orderby(){
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
                }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
    protected function handleSubClasses($section){
        $classes = [];
        foreach($section->sections as $subSection){
            $subSection->classes = [];
            if($subSection->sections->count() > 0 || $subSection->lessons->count() > 0){
                $subSection->classes = $this->classes($subSection);
            }

            $classes[]= [
                'index' => $subSection->index,
                'type' => 'section',
                'data' => $subSection
            ];
        }
        foreach($section->lessons as $lesson){
            $classes[]= [
                'index' => $lesson->index,
                'type' => 'lesson',
                'data' => $lesson
            ];
        }
        $classes = $this->array_orderby($classes, 'index');
        return $classes;
    }
    #endregion LOCAL FUNCTIONS
}