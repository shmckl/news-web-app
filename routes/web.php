<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Models\Post;
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

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/newpost', function () {
    return view('newpost');
})->middleware(['auth', 'verified'])->name('newpost');

Route::post('/newpost', [PostController::class, 'store'])->middleware(['auth', 'verified'])->name('posts.store');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware(['auth', 'verified'])->name('post.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware(['auth', 'verified'])->name('post.destroy');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware(['auth', 'verified'])->name('comment.store');

Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comment.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

Route::get('/posts/{post}/edit', function (Post $post) {
    return view('editpost', [
        'post' => $post,
    ]);
})->middleware(['auth', 'verified'])->name('post.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

//route image.upload post controller
Route::post('/image-upload', [PostController::class, 'imageUploadPost'])->name('image.upload');