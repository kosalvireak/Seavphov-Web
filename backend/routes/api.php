<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\CorsMiddleware;
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
Route::get('books/{id}',  [BookController::class, 'show'])->name('book.show');
Route::post('books', [BookController::class, 'store'])->name('book.store')->middleware([CorsMiddleware::class]);
Route::put('books/{id}', [BookController::class, 'update'])->name('book.update');
Route::delete('books/{id}', [BookController::class, 'delete'])->name('book.delete');


Route::post('user/register', [RegisterController::class, 'register'])->name('user.register');
