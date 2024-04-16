<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () {
    return "Hello World!";
});
Route::get('books',  [BookController::class, 'index'])->name('book.index');
Route::get('auth/books',  [BookController::class, 'authIndex'])->middleware([ApiTokenAuthentication::class]);
Route::get('books/{id}',  [BookController::class, 'show'])->name('book.show');
Route::post('books', [BookController::class, 'store'])->name('book.store')->middleware([ApiTokenAuthentication::class]);
Route::put('books/{id}', [BookController::class, 'update'])->name('book.update');
Route::delete('books/{id}', [BookController::class, 'delete'])->name('book.delete');

Route::get('user/profile/{id}', [LoginController::class, 'profile'])->middleware([ApiTokenAuthentication::class]);
Route::post('user/login', [LoginController::class, 'login'])->name('user.login');
Route::post('user/register', [RegisterController::class, 'register'])->name('user.register');
