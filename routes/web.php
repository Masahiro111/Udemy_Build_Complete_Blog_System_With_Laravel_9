<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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

// User Routes

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/post/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

Route::post('/post/{post:slug}', [PostController::class, 'addComment'])
    ->name('posts.add_comment');

Route::get('/about', AboutController::class)->name('about');

Route::get('/contact', [ContactController::class, 'create'])
    ->name('contact.create');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/tags/{tag:name}', [TagController::class, 'show'])
    ->name('tags.show');

require __DIR__ . '/auth.php';



// Admin Dashboard Routes

Route::get('/admin', [DashboardController::class, 'index'])
    ->name('admin.index');
