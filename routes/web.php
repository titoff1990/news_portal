<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('main.main');
});

//Cтандартные роуты bootstrap
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Новости
Route::get('news/search', [NewsController::class, 'search'])->name('news.search');
Route::get('news/show_more', [NewsController::class, 'showMore'])->name('news.show_more');
Route::resource('news', NewsController::class);

// Поиск
Route::get('search', [SearchController::class, 'index'])->name('search');

// Категории
Route::resource('category', CategoryController::class);

// Комментарии
Route::resource('comment', CommentController::class);

//Теги
Route::resource('tag', TagController::class);

