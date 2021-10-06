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
    ];
}