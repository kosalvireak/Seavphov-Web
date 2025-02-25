<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminAuthorization;
use App\Http\Middleware\ApiTokenAuthentication;
use App\Http\Middleware\OptionalApiTokenAuthentication;
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

Route::prefix('auth/book')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('', [BookController::class, 'getMyBooks']);
    Route::get('{id}', [BookController::class, 'getMyBook']);
});

Route::prefix('books')->group(function () {
    Route::get('',  [BookController::class, 'fetchBooksWithFilter']);
    Route::get('/banner',  [BannerController::class, 'getBanner']);
    Route::get('/newest',  [BookController::class, 'getNewest']);
    Route::get('/mostReviewed',  [BookController::class, 'getMostReviewed']);
    Route::get('/availability/{id}',  [BookController::class, 'changeAvailability'])->middleware([ApiTokenAuthentication::class]);
    Route::post('{bookId}',  [BookController::class, 'fetchBookById']);
    Route::post('', [BookController::class, 'createBook'])->middleware([ApiTokenAuthentication::class]);
    Route::put('{id}', [BookController::class, 'modifyBook'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('{id}', [BookController::class, 'deleteBook'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('review')->group(function () {
    Route::get('/book/{id}', [BookReviewController::class, 'fetchBookReviews'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/like/{id}', [BookReviewController::class, 'likeReview'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/dislike/{id}', [BookReviewController::class, 'dislikeReview'])->middleware([ApiTokenAuthentication::class]);
    Route::post('/add', [BookReviewController::class, 'createReview'])->middleware([ApiTokenAuthentication::class]);
    Route::put('/edit/{id}', [BookReviewController::class, 'editReview'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('/delete/{id}', [BookReviewController::class, 'deleteReview'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('comment')->group(function () {
    Route::get('/discussion/{id}', [CommentController::class, 'fetchDiscussionComments'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/like/{id}', [CommentController::class, 'likeComment'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/dislike/{id}', [CommentController::class, 'dislikeComment'])->middleware([ApiTokenAuthentication::class]);
    Route::post('/add', [CommentController::class, 'createComment'])->middleware([ApiTokenAuthentication::class]);
    Route::put('/edit/{id}', [CommentController::class, 'editComment'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('/delete/{id}', [CommentController::class, 'deleteComment'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('discussions')->group(function () {
    Route::get('', [DiscussionController::class, 'fetchDiscussions'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('{id}', [DiscussionController::class, 'fetchDiscussionById'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/like/{id}', [DiscussionController::class, 'likeDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/dislike/{id}', [DiscussionController::class, 'dislikeDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::post('', [DiscussionController::class, 'createDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('/delete/{id}', [DiscussionController::class, 'deleteDiscussion'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('profile')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('', [UserController::class, 'fetchUserProfile']);
    Route::put('', [UserController::class, 'modifyUserProfile']);
});

Route::prefix('user')->group(function () {
    Route::get('{uuid}', [UserController::class, 'fetchOtherUserProfile']);
    Route::post('login', [LoginController::class, 'loginUser']);
    Route::post('register', [RegisterController::class, 'registerUser']);
});

Route::prefix('saved')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('{bookId}', [UserBookController::class, 'saveBook']);
    Route::get('', [UserBookController::class, 'fetchSavedBook']);
});

Route::prefix('notification')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('', [NotificationController::class, 'getNotifications']);
});


Route::prefix('admin')->middleware([ApiTokenAuthentication::class, AdminAuthorization::class])->group(function () {
    Route::get('/auth', [AdminController::class, 'adminGetAuth']);
    Route::get('/overview', [AdminController::class, 'adminGetOverviewData']);
    Route::get('/books', [AdminController::class, 'adminGetBooks']);
    Route::get('/books/delete/{id}', [AdminController::class, 'adminDeleteBook']);
    Route::get('/users', [AdminController::class, 'adminGetUsers']);
    Route::get('/banners', [BannerController::class, 'adminGetBanners']);
    Route::post('/banners', [BannerController::class, 'adminAddBanner']);
    Route::get('/banners/{id}', [BannerController::class, 'adminDeleteBanner']);
    Route::get('/banners/selected/{id}', [BannerController::class, 'changeSelectedBanner']);
});

Route::prefix('reset')->group(function () {
    Route::post('/', [UserController::class, 'resetPassword']);
    Route::post('/send', [UserController::class, 'sendEmailResetPassword']);
});
