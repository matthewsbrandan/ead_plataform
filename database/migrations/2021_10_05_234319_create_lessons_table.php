<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->longText('content')->nullable();
            $table->text('url')->nullable();
            $table->time('duration')->default('00:00:00.0000000');
            $table->enum('type',['video','article','archive']);
            $table->integer('num_views')->default(0);
            $table->integer('num_comments')->default(0);
            $table->integer('rating')->nullable();
            $table->string('breadcrumbs')->nullable();
            $table->integer('depth')->default(0);
            $table->integer('index')->default(0);
            $table->integer('real_index')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
