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

    public function students(){
        return $this->belongsToMany(User::class, 'user_courses', 'course_id', 'user_id');
    }
    public function studentsPivot(){
        return $this->hasMany(UserCourse::class, 'course_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
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
}