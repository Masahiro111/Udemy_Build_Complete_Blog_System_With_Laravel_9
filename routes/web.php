<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/post/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

Route::post('/post/{post:slug}', [PostController::class, 'addComment'])
    ->name('posts.add_comment');

Route::get('/about', AboutController::class)->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
