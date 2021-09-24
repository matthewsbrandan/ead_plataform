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

Route::get('/', '\App\Http\Controllers\Controller@index');
Route::get('/login', '\App\Http\Controllers\Controller@login')->name('login');
Route::post('/logar', '\App\Http\Controllers\Controller@logar')->name('logar');
Route::get('/cadastrar', '\App\Http\Controllers\Controller@register')->name('register');
Route::post('/cadastrar/salvar', '\App\Http\Controllers\Controller@store')->name('store');
Route::get('/home', '\App\Http\Controllers\Controller@home')->name('home');
