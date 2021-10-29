<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'index',
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
    #endregion RELATIONSHIPS
    public function getTypeFormatted(){
        $types = [
            'video' => 'Vídeo',
            'article' => 'Artigo',
            'archive' => 'Arquivos'
        ];

        return $types[$this->type] ?? null;
    }
    public function formatDuration(){
        if($this->type == 'archive') return "-";
        $strDate = "";
        $hours = $this->duration->format('H');
        $minutes = $this->duration->format('i');
        if($hours > 0) $strDate = $hours."h ";
        if($minutes > 0) $strDate.= $minutes."min";
        if(strlen($strDate) == 0) $strDate = "0min";

        return $strDate;
    }
}