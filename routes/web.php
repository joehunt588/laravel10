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

Route::get('/', [userController::class, 'showCorrectHomePage']);
Route::post('/login', [userController::class, 'login']);
Route::post('/register', [userController::class, 'register']);
Route::post('/logout', [userController::class, 'logout']);

//blog
Route::get('/create-post', [PostController::class, 'showCreateForm']);