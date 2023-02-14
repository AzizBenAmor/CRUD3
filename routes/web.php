<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
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

Route::get('/home',[HomeController::class,'index'] )->name('home');
Route::get('posts/{post}',[PostController::class,'show'] )->name('posts.show');
Route::get('/about', function () {
    return view('about');
});
Route::resource('categories',CategoryController::class);

Route::get('/contact', function () {
    return view('contact');
});
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');})->name('dashboard');
       });
       Route::group(['middleware' => ['is_Admin']], function() {
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        Route::resource('posts', \App\Http\Controllers\PostController::class);
    });