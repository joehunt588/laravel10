<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\userController;
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

Route::get('/', [userController::class, 'showCorrectHomePage'])->name('login');
Route::post('/login', [userController::class, 'login'])->middleware('guest');
Route::post('/register', [userController::class, 'register'])->middleware('guest');
Route::post('/logout', [userController::class, 'logout'])->middleware('mustBeLoggedIn');

//blog
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{postedid}', [PostController::class, 'viewSinglePost']);

// Route::get('/', [userController::class, 'showCorrectHomePage'])->name('login')->middleware('custom_guest');
// Route::post('/login', [userController::class, 'login'])->middleware('custom_guest');
// Route::post('/register', [userController::class, 'register'])->middleware('custom_guest');
// Route::post('/logout', [userController::class, 'logout'])->middleware('custom_auth');

// // Blog
// Route::middleware('custom_auth')->group(function () {
//     Route::get('/create-post', [PostController::class, 'showCreateForm']);
//     Route::post('/create-post', [PostController::class, 'storeNewPost']);
// });

// Route::get('/post/{postedid}', [PostController::class, 'viewSinglePost']);
