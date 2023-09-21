<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ArticleController,
    RegisterController
};

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

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('post.register');


Route::get('/', function () {
    return view('layouts.main');
});

Route::get('profile/{username}', [UserController::class, 'profile'])
    ->name('user.profile');

Route::resource('article', ArticleController::class);

Route::get('test', function () {
    return view('test');
});

Route::get('structures', function () {
   return view('structures');
});
