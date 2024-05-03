<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\ApiTokenAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('auth/book')->middleware([ApiTokenAuthentication::class])->group(function(){
    Route::get('',[BookController::class, 'getMyBooks']);
    Route::get('{id}',[BookController::class, 'getMyBook']);
});

Route::prefix('books')->group(function () {
    Route::get('',  [BookController::class, 'index']);
    Route::get('{bookId}',  [BookController::class, 'show']);
    Route::post('', [BookController::class, 'store'])->middleware([ApiTokenAuthentication::class]);
    Route::put('{id}', [BookController::class, 'modifyBook'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('{id}', [BookController::class, 'deleteBook'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('profile')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('',[UserController::class, 'index']);
    Route::put('', [UserController::class, 'update']);
});

Route::prefix('user')->group(function () {
    Route::get('{userName}',[UserController::class,'getUser']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
});

Route::prefix('saved')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('{bookId}', [UserBookController::class, 'saveBook']);
    Route::get('', [UserBookController::class, 'getSaveBook']);
    Route::delete('{bookId}', [UserBookController::class, 'removeBook']);
});