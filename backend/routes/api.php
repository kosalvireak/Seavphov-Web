<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
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
Route::get('auth/books',  [BookController::class, 'authIndex'])->middleware([ApiTokenAuthentication::class]);

Route::prefix('books')->group(function () {
    Route::get('',  [BookController::class, 'index']);
    Route::get('{id}',  [BookController::class, 'show']);
    Route::post('', [BookController::class, 'store'])->middleware([ApiTokenAuthentication::class]);
    Route::put('{id}', [BookController::class, 'update']);
    Route::delete('{id}', [BookController::class, 'delete']);
});

Route::prefix('profile')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('',[UserController::class, 'index']);
    Route::put('', [UserController::class, 'update']);
});

Route::prefix('user')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
});