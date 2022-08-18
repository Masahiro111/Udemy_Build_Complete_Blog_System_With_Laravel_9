<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminControllers\AdminCategoriesController;
use App\Http\Controllers\AdminControllers\AdminPostsController;
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

Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('index');

    Route::prefix('/posts')
        ->controller(AdminPostsController::class)
        ->name('posts.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('', 'store')->name('store');
            Route::get('{post}', 'show')->name('show');
            Route::get('{post}/edit', 'edit')->name('edit');
            Route::put('{post}', 'update')->name('update');
            Route::delete('{post}', 'destroy')->name('destroy');
        });

    Route::prefix('/categories')
        ->controller(AdminCategoriesController::class)
        ->name('categories.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('', 'store')->name('store');
            Route::get('{category}', 'show')->name('show');
            Route::get('{category}/edit', 'edit')->name('edit');
            Route::put('{category}', 'update')->name('update');
            Route::delete('{category}', 'destroy')->name('destroy');
        });

    Route::prefix('/tags')
        ->controller(AdminTagsController::class)
        ->name('tags.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('{category}', 'show')->name('show');
            Route::delete('{category}', 'destroy')->name('destroy');
        });

    Route::prefix('/comments')
        ->controller(AdminCommentsController::class)
        ->name('comments.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('', 'store')->name('store');
            Route::get('{comments}/edit', 'edit')->name('edit');
            Route::put('{comments}', 'update')->name('update');
            Route::delete('{comments}', 'destroy')->name('destroy');
        });
});
