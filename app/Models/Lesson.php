<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'url',
        'duration',
        'type',
        'num_views',
        'num_comments',
        'rating',
        'breadcrumbs',
        'depth',
        'index', // INDEX DENTRO DA SECTION (Conta apenas itens do mesmo DEPTH)
        'real_index', // INDEX DENTRO DO COURSE (Conta todas as aulas)
        'user_id',
        'course_id',
        'section_id',
    ];
    protected $dates = [
        'duration',
    ];

    #region RELATIONSHIPS
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }
    public function students(){
        return $this->belongsToMany(User::class, 'user_lessons', 'lesson_id', 'user_id');
    }
    public function studentsPivot(){
        return $this->hasMany(UserLesson::class, 'lesson_id');
    }
    public function chat(){
        return $this->hasMany(Chat::class, 'lesson_id');
    }
    #endregion RELATIONSHIPS
    public function student($json = false){
        $student = $this->studentsPivot->where('user_id', auth()->user()->id)->first();
        if($json) return $student ? $student->toJson() : null;
        return $student;
    }
    public function getTypeFormatted(){
        $types = [
            'video' => 'Vídeo',
            'article' => 'Artigo',
            'archive' => 'Arquivos'
        ];

        return $types[$this->type] ?? null;
    }
    public function formatDuration(){
        if($this->type == 'archive' || !$this->duration) return "-";
        $strDate = "";
        try{
            $hours = $this->duration->format('H');
            $minutes = $this->duration->format('i');
            if($hours > 0) $strDate = $hours."h ";
            if($minutes > 0) $strDate.= $minutes."min";
            if(strlen($strDate) == 0) $strDate = "0min";

            return $strDate;
        }catch(Exception $e){
            return "-";
        }
    }
    public function getDurationInSeconds(){
        if($this->type == 'archive' || !$this->duration) return 0;
        try{
            $hours = $this->duration->format('H');
            $minutes = $this->duration->format('i');
            $seconds = $this->duration->format('s');
            return ($hours * 60 * 60) + ($minutes * 60) + $seconds;
        }catch(Exception $e){
            return 0;
        }
    }
    public function getArchiveToArray(){
        return json_decode($this->content, true);
    }
    public function formatArchiveContent(){
        $archives = $this->getArchiveToArray();
        $html = "<div class=\"list-archive\">";
        foreach($archives as $archive){
            $html.= "<div class=\"archive-item\">";
            $html.= "<a href=\"{$archive['link']}\">Link Externo</a>";
            $html.= "<p>{$archive['description']}</p>";
            $html.= "</div>";
        }
        $html.="</div>";
    }
}