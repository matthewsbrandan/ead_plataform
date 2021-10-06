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
        'num_views',
        'num_comments',
        'rating',
        'breadcrumbs',
        'depth',
        'user_id',
        'course_id',
        'section_id',
    ];
}