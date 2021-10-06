<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $categories = [
            [
                'title' => 'Inglês',
                'slug' => 'ingles',
                'wallpaper' => config('app.url').'/assets/images/english.svg',
                'description' => "I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.",
            ],[
                'title' => 'Ciências',
                'slug' => 'ciencias',
                'wallpaper' => config('app.url').'/assets/images/science.svg',
                'description' => "I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.",
            ],[
                'title' => 'História',
                'slug' => 'historia',
                'wallpaper' => config('app.url').'/assets/images/history.svg',
                'description' => "I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.",
            ],[
                'title' => 'Matemática',
                'slug' => 'matematica',
                'wallpaper' => config('app.url').'/assets/images/math.svg',
                'description' => "I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.",
            ],[
                'title' => 'Outros',
                'slug' => 'outros',
                'wallpaper' => config('app.url').'/assets/images/outhers.png',
                'description' => "I'm a paragraph. Click here to add your own text and edit me. Let your users get to know you.",
            ]
        ];

        foreach($categories as $category){
            Category::create($category);
        }

    }
}
