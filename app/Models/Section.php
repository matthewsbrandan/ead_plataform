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
        'num_children',
        'section_id',
        'course_id',
    ];
}
