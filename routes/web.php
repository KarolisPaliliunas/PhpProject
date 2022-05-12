<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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
    return view('welcome');
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/

//Route::get('/dashboard', function () {
//    return view('show-topics');
//})->middleware(['auth'])->name('show-topics');

// TOPICS
Route::get('/dashboard', [TopicController::class, 'index'])->middleware(['auth'])->middleware('verified')->name('dashboard');
Route::get('/create-topic', [TopicController::class, 'create'])->name('create-topic');
Route::post('/store-topic', [TopicController::class, 'store'])->name('store-topic');
Route::post('/delete-topic/{topic_id}', [TopicController::class, 'destroy'])->name('delete-topic');
Route::get('/edit-topic/{topic_id}', [TopicController::class, 'edit'])->name('edit-topic');
Route::post('/update-topic/{topic_id}', [TopicController::class, 'update'])->name('update-topic');

//POSTS
Route::get('/posts/{topic_id}', [PostController::class, 'show'])->middleware(['auth'])->middleware('verified')->name('posts');
Route::get('/create-post/{topic_id}', [PostController::class, 'create'])->name('create-post');
Route::post('/store-post/{topic_id}', [PostController::class, 'store'])->name('store-post');
Route::post('/delete-post/{topic_id}/{post_id}', [PostController::class, 'destroy'])->name('delete-post');
Route::get('/edit-post/{topic_id}/{post_id}', [PostController::class, 'edit'])->name('edit-post');
Route::post('/update-post/{topic_id}/{post_id}', [PostController::class, 'update'])->name('update-post');

//COMMENTS
Route::get('/comments/{post_id}', [CommentController::class, 'show'])->middleware(['auth'])->middleware('verified')->name('comments');
Route::post('/store-comment/{post_id}', [CommentController::class, 'store'])->name('store-comment');
Route::post('/delete-comment/{post_id}/{comment_id}', [CommentController::class, 'destroy'])->name('delete-comment');


require __DIR__.'/auth.php';
