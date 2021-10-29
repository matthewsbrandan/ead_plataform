<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'breadcrumbs',
        'depth',
        'index',
        'num_children',
        'section_id',
        'course_id'
    ];

    #region RELATIONSHIPS
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function fatherSection(){
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function sections(){
        return $this->hasMany(Section::class, 'section_id');
    }
    public function lessons(){
        return $this->hasMany(Lesson::class, 'section_id');
    }
    #endregion RELATIONSHIPS
    public function array_breadcrumbs(){
        return $this->breadcrumbs ? explode(',', $this->breadcrumbs) : [];
    }
}