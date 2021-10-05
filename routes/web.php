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

Route::get('/', function(){ return view('welcome'); })->name('index');

// BEGIN:: REGISTER
Route::get('/cadastrar', 'App\Http\Controllers\UserController@create')->name('register');
Route::post('/cadastrar/salvar', 'App\Http\Controllers\UserController@store')->name('user.store');
// END:: REGISTER | BEGIN:: LOGIN
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')->name('login');
Route::get('/login', function(){
  if (Auth::check()) return redirect()->route('home');
  return view('auth.login');
})->name('login');
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

Route::middleware(['auth'])->group(function() {
  Route::get('/home','App\Http\Controllers\HomeController@index')->name('home');

  Route::name('course.')->group(function(){
    Route::get('/meus-cursos', 'App\Http\Controllers\CourseController@index')->name('index');
  });
  
  Route::name('chat.')->group(function(){
    Route::get('/chats', 'App\Http\Controllers\ChatController@index')->name('index');
  });

  Route::name('user.')->group(function(){
    Route::get('/perfil', 'App\Http\Controllers\UserController@profile')->name('profile');
    Route::get('/notificacoes', 'App\Http\Controllers\UserController@notification')->name('notification');
  });
});
