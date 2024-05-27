<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminAuthorization;
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
    Route::get('',  [BookController::class, 'fetchBooksWithFilter']);
    Route::get('/banner',  [BannerController::class, 'getBanner']);
    Route::post('{bookId}',  [BookController::class, 'fetchBookById']);
    Route::post('', [BookController::class, 'createBook'])->middleware([ApiTokenAuthentication::class]);
    Route::put('{id}', [BookController::class, 'modifyBook'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('{id}', [BookController::class, 'deleteBook'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('profile')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('',[UserController::class, 'fetchUserProfile']);
    Route::put('', [UserController::class, 'modifyUserProfile']);
});

Route::prefix('user')->group(function () {
    Route::get('{uuid}',[UserController::class,'fetchOtherUserProfile']);
    Route::post('login', [LoginController::class, 'loginUser']);
    Route::post('register', [RegisterController::class, 'registerUser']);
});

Route::prefix('saved')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('notification', [UserBookController::class, 'getSavedBooksNotification']);
    Route::get('{bookId}', [UserBookController::class, 'saveBook']);
    Route::get('', [UserBookController::class, 'fetchSavedBook']);
    Route::delete('{bookId}', [UserBookController::class, 'unSaveBook']);
});


Route::prefix('admin')->middleware([ApiTokenAuthentication::class, AdminAuthorization::class])->group(function(){
    Route::get('/auth',[AdminController::class, 'adminGetAuth']);
    Route::get('/overview',[AdminController::class, 'adminGetOverviewData']);
    Route::get('/books',[AdminController::class, 'adminGetBooks']);
    Route::get('/books/delete/{id}',[AdminController::class, 'adminDeleteBook']);
    Route::get('/users',[AdminController::class, 'adminGetUsers']);
    Route::get('/banners',[BannerController::class, 'adminGetBanners']);
    Route::post('/banners',[BannerController::class, 'adminAddBanner']);
    Route::get('/banners/{id}',[BannerController::class, 'adminDeleteBanner']);
    Route::get('/banners/selected/{id}',[BannerController::class, 'changeSelectedBanner']);
});

Route::prefix('reset')->group(function(){
    Route::post('/',[UserController::class,'resetPassword']);
    Route::post('/send',[UserController::class,'sendEmailResetPassword']);
});