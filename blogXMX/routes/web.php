<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PostController::class, 'index']);

Route::get('/post/{id}', [PostController::class, 'details']);

Route::post('/post/{id}/like', [PostController::class, 'like'])->name('post.like');
Route::post('/post/{id}/dislike', [PostController::class, 'dislike'])->name('post.dislike');
Route::post('/post/comment', [PostController::class, 'addComment'])->name('post.addComment');

Route::post('/comment/{id}/like', [PostController::class, 'comment_like'])->name('comment.like');


Route::get('/user/{id}', [UserController::class, 'show'])->name('userView');