<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ArticleController,
    RegisterController,
    LoginController,
    LogoutController,
    ForgotController,
    ResetController,
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

// Routes GET
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('forgot', [ForgotController::class, 'index'])->name('forgot');
Route::get('reset/{token}', [ResetController::class, 'index'])->name('reset');

//Routes POST
Route::post('register', [RegisterController::class, 'register'])->name('post.register');
Route::post('login', [LoginController::class, 'login'])->name('post.login');
Route::post('forgot', [ForgotController::class, 'store'])->name('post.forgot');
Route::post('reset', [ResetController::class, 'reset'])->name('post.reset');

Route::resource('articles', ArticleController::class);

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
