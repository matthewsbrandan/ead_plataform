<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->integer('num_answers')->default(0);
            $table->integer('depth')->default(0);
            $table->text('breadcrumbs')->nullable();
            $table->boolean('is_course')->default(false);
            $table->foreignId('lesson_id')->nullable()->constrained('lessons');
            $table->foreignId('course_id')->nullable()->constrained('courses');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('answer_id')
                ->nullable()
                ->constrained('chats')
                ->onDelete('cascade');
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
        Schema::dropIfExists('chats');
    }
}
