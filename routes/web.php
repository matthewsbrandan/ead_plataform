<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\HomeController@welcome')->name('index');
// BEGIN:: REGISTER
Route::get('/cadastrar', 'App\Http\Controllers\UserController@create')->name('register');
Route::post('/cadastrar/salvar', 'App\Http\Controllers\UserController@store')->name('user.store');
// END:: REGISTER | BEGIN:: LOGIN
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')->name('login');
Route::get('/login', function(){
  if (Auth::check()) return redirect()->route('home');
  return view('auth.login');
})->name('login');
Route::get('/logar-e-retornar', function(){
  $url = \URL::previous();
  return view('auth.login',['goback' => $url]);
})->name('login_goback');
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// END:: LOGIN | BEGIN:: FORGOT PASSWORD
Route::get('/esqueci-minha-senha',
  'App\Http\Controllers\UserController@forgotPassword'
)->name('forgot_password');
Route::post('/solicitando-redefinicao-de-senha',
  'App\Http\Controllers\UserController@sendRedefinePassword'
)->name('send_redefine_password');
Route::get('/redefinicao-de-senha/{email}&{token}',
  'App\Http\Controllers\UserController@redefinePassword'
)->name('redefine_password');
Route::post('/redefinindo-senha',
  'App\Http\Controllers\UserController@storePassword'
)->name('store_password');
// END:: FORGOT PASSWORD

Route::get('/explorar-cursos/{search?}', 'App\Http\Controllers\ExplorerController@index')->name('explorer');
Route::middleware(['auth'])->group(function() {
  Route::get('/home','App\Http\Controllers\HomeController@index')->name('home');

  Route::name('class.')->group(function(){
    Route::get('/curso/apresentacao/{slug}', 'App\Http\Controllers\ClassController@index')->name('index');
    Route::get('/aulas/chat/{slug}/{id?}','App\Http\Controllers\ClassController@chat')->name('chat');
    Route::get('/aulas/outros/{slug}/{id?}','App\Http\Controllers\ClassController@outhers')->name('outhers');
    Route::get('/matricular-se/{slug}', 'App\Http\Controllers\ClassController@subscribe')->name('subscribe');
    Route::get('/aulas/avaliar/{course_id}/{id}/{rating}', 'App\Http\Controllers\UserLessonController@rating')->name('rating');
    Route::post('/aulas/{slug}/assistida', 'App\Http\Controllers\UserLessonController@toView')->name('toView');
    Route::get('/aulas/{slug}/{id?}','App\Http\Controllers\ClassController@show')->name('show');
  });

  Route::name('course.')->group(function(){
    Route::get('/cursos', 'App\Http\Controllers\CourseController@index')->name('index');
    Route::get('/cursos/mais/{skip}', 'App\Http\Controllers\CourseController@index')->name('index.more');
    
    Route::get('/meus-cursos', 'App\Http\Controllers\CourseController@mine')->name('mine');
    Route::name('mine.')->group(function(){
      Route::get('/meus-cursos/mais/{skip}', 'App\Http\Controllers\CourseController@mine')->name('more');
      Route::get('/meus-cursos/editar/{id}', 'App\Http\Controllers\CourseController@edit')->name('edit');
      Route::post('/meus-cursos/editar/salvar', 'App\Http\Controllers\CourseController@update')->name('update');
      Route::get('/meus-cursos/publicar/{id}', 'App\Http\Controllers\CourseController@publish')->name('publish');
      Route::get('/meus-cursos/delete/{id}', 'App\Http\Controllers\CourseController@delete')->name('delete');
    });

    Route::get('/novo-curso', 'App\Http\Controllers\CourseController@create')->name('create');
    Route::post('/novo-curso/salvar', 'App\Http\Controllers\CourseController@store')->name('store');

    Route::get('/curso/avaliar/{id}/{rating}', 'App\Http\Controllers\CourseController@rating')->name('rating');
  });

  Route::name('lesson.')->group(function(){
    Route::get('/nova-aula/{slug}','App\Http\Controllers\LessonController@create')->name('create');
    
    Route::name('class.')->group(function(){
      Route::get('/nova-aula/{slug}/aula/{section_id?}/{type?}',
        'App\Http\Controllers\LessonController@class'
      )->name('create');
      Route::get('/editar-aula/{slug}/aula/{id}',
        'App\Http\Controllers\LessonController@edit'
      )->name('edit');
      Route::get('/excluir-aula/{slug}/aula/{id}',
        'App\Http\Controllers\LessonController@delete'
      )->name('delete');
      Route::post('/nova-aula/{slug}/aula/salvar',
        'App\Http\Controllers\LessonController@store'
      )->name('store');
    });
  });
  
  Route::name('chat.')->group(function(){
    Route::get('/chats', 'App\Http\Controllers\ChatController@index')->name('index');
    Route::get('/chats/aula/{lesson_id}/{skip?}', 'App\Http\Controllers\ChatController@chatLesson')->name('lesson');
    Route::get('/chats/curso/{slug}/{user_id}/{skip?}', 'App\Http\Controllers\ChatController@chatCourse')->name('course');
    Route::post('/chats/enviar', 'App\Http\Controllers\ChatController@store')->name('store');
  });

  Route::name('user.')->group(function(){
    Route::name('profile.')->group(function(){
      Route::get('/perfil', 'App\Http\Controllers\UserController@profile')->name('index');
      Route::get('/perfil/atualizar-tipo/{type}', 'App\Http\Controllers\UserController@changeType')->name('change_type');
      Route::post('/perfil/atualizar', 'App\Http\Controllers\UserController@update')->name('update');
      Route::post('/perfil/atualizar-senha', 'App\Http\Controllers\UserController@changePassword')->name('change_password');
    });

    Route::get('/notificacoes', 'App\Http\Controllers\UserController@notification')->name('notification');
  });

  Route::name('category.')->group(function(){
    Route::get('/categorias', 'App\Http\Controllers\CategoryController@index')->name('index');
    Route::get('/categorias/editar/{id}', 'App\Http\Controllers\CategoryController@edit')->name('edit');
    Route::post('/categorias/salvar', 'App\Http\Controllers\CategoryController@store')->name('store');
  });

  Route::name('section.')->group(function(){
    Route::post('/secao/salvar','App\Http\Controllers\SectionController@store')->name('store');
    Route::get('/secao/excluir/{id}','App\Http\Controllers\SectionController@delete')->name('delete');
  });

  Route::name('feedback.')->group(function(){
    Route::get('/feedback', 'App\Http\Controllers\FeedbackController@index')->name('index');
    Route::post('/feedback/salvar', 'App\Http\Controllers\FeedbackController@store')->name('store');
    Route::get('/feedback/excluir/{id}', 'App\Http\Controllers\FeedbackController@delete')->name('delete');

    Route::get('/feedback/ver', 'App\Http\Controllers\FeedbackController@show')->name('show');
    Route::get('/feedback/ver/mais/{skip?}', 'App\Http\Controllers\FeedbackController@show')->name('show');
  });
});
