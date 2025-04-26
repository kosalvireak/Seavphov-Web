<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CopMemberController;
use App\Http\Controllers\ReadingChallengeController;
use App\Http\Controllers\ReadingProgressController;
use App\Http\Middleware\AdminAuthorization;
use App\Http\Middleware\ApiTokenAuthentication;
use App\Http\Middleware\CopAdminAuthorization;
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

Route::prefix('reading-challenge')->group(function () {
    Route::get('{route}/{id}', [ReadingChallengeController::class, 'getReadingChallenge'])->middleware([ApiTokenAuthentication::class]);
    Route::get('{route}', [ReadingChallengeController::class, 'getReadingChallenges'])->middleware([OptionalApiTokenAuthentication::class]);;
    Route::post('{route}/add', [ReadingChallengeController::class, 'addReadingChallenge'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
    Route::get('{route}/{id}/join', [ReadingChallengeController::class, 'startReadingChallenge'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('members/reading-challenge')->middleware([ApiTokenAuthentication::class])->group(function () {
    // Members
    Route::get('{id}', [ReadingChallengeController::class, 'getReadingChallengeMembers']);
    Route::get('my-progress/{id}', [ReadingProgressController::class, 'getMyReadingProgress']);
    Route::post('/update-progress/{id}', [ReadingProgressController::class, 'updateReadingProgress']);
    Route::delete('/withdraw/{id}', [ReadingProgressController::class, 'withDrawChallenge']);
});

Route::prefix('community')->group(function () {
    Route::get('', [CommunityController::class, 'searchCommunity'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/route/{route}', [CommunityController::class, 'getCommunityByRoute']);
    Route::post('/new', [CommunityController::class, 'createCommunity'])->middleware([ApiTokenAuthentication::class]);
    Route::put('/edit/{route}', [CommunityController::class, 'editCommunity'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
    Route::delete('/delete/{route}', [CommunityController::class, 'deleteCommunity'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);

    // Members
    Route::get('{route}/members', [CopMemberController::class, 'getCommunityMembers'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
    Route::get('{route}/member-requests', [CopMemberController::class, 'getCommunityMemberRequest'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
    Route::post('{route}/change-role', [CopMemberController::class, 'changeUserRole'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
    Route::post('{route}/remove-member/{uuid}', [CopMemberController::class, 'removeMemberFromCop'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);


    // Check Permission
    Route::get('{route}/permission/home', [CommunityController::class, 'checkViewCopHomePermission'])->middleware([OptionalApiTokenAuthentication::class]);

    // Join cop
    Route::get('{route}/request-to-join-community', [CopMemberController::class, 'requestToJoinCop'])->middleware([ApiTokenAuthentication::class]);
    Route::get('{route}/join-community', [CopMemberController::class, 'joinCop'])->middleware([ApiTokenAuthentication::class]);

    // Leave cop
    Route::get('{route}/leave-community', [CopMemberController::class, 'leaveCommunity'])->middleware([ApiTokenAuthentication::class]);

    // Approve or Reject request
    Route::post('{route}/approved', [CopMemberController::class, 'approveMemberRequest'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
    Route::post('{route}/reject', [CopMemberController::class, 'rejectMemberRequest'])->middleware([ApiTokenAuthentication::class, CopAdminAuthorization::class]);
});

Route::prefix('books')->group(function () {
    Route::get('',  [BookController::class, 'getBooksWithFilter']);
    Route::get('/banner',  [BannerController::class, 'getBanner']);
    Route::get('/newest',  [BookController::class, 'getNewest']);
    Route::get('/mostReviewed',  [BookController::class, 'getMostReviewed']);
    Route::get('/availability/{id}',  [BookController::class, 'changeAvailability'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/{bookId}',  [BookController::class, 'getBookDetailWithOwner'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::post('', [BookController::class, 'addBook'])->middleware([ApiTokenAuthentication::class]);
    Route::put('{id}', [BookController::class, 'modifyBook'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('{id}', [BookController::class, 'deleteBook'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('review')->group(function () {
    Route::get('/book/{id}', [BookReviewController::class, 'getReviewsOfBook'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/like/{id}', [BookReviewController::class, 'likeReview'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/my-reviews', [BookReviewController::class, 'getMyReviews'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/dislike/{id}', [BookReviewController::class, 'dislikeReview'])->middleware([ApiTokenAuthentication::class]);
    Route::post('/add', [BookReviewController::class, 'createReview'])->middleware([ApiTokenAuthentication::class]);
    Route::put('/edit/{id}', [BookReviewController::class, 'editReview'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('/delete/{id}', [BookReviewController::class, 'deleteReview'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('comment')->group(function () {
    Route::get('/discussion/{id}', [CommentController::class, 'getCommentsOfDiscussion'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/like/{id}', [CommentController::class, 'likeComment'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/dislike/{id}', [CommentController::class, 'dislikeComment'])->middleware([ApiTokenAuthentication::class]);
    Route::post('/add', [CommentController::class, 'createComment'])->middleware([ApiTokenAuthentication::class]);
    Route::put('/edit/{id}', [CommentController::class, 'editComment'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('/delete/{id}', [CommentController::class, 'deleteComment'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/my-comments', [CommentController::class, 'getMyComments'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('discussions')->group(function () {
    Route::get('', [DiscussionController::class, 'getDiscussionsWithFilter'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/my-discussions', [DiscussionController::class, 'getMyDiscussions'])->middleware([ApiTokenAuthentication::class]);
    Route::get('{id}', [DiscussionController::class, 'getDiscussionById'])->middleware([OptionalApiTokenAuthentication::class]);
    Route::get('/like/{id}', [DiscussionController::class, 'likeDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::get('/dislike/{id}', [DiscussionController::class, 'dislikeDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::post('', [DiscussionController::class, 'createDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::put('/edit/{id}', [DiscussionController::class, 'editDiscussion'])->middleware([ApiTokenAuthentication::class]);
    Route::delete('/delete/{id}', [DiscussionController::class, 'deleteDiscussion'])->middleware([ApiTokenAuthentication::class]);
});

Route::prefix('saved')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('{bookId}', [UserBookController::class, 'saveBook']);
    Route::get('', [UserBookController::class, 'getSavedBook']);
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

Route::prefix('user')->middleware([ApiTokenAuthentication::class])->group(function () {
    Route::get('', [UserController::class, 'getProfile']);
    Route::put('/edit', [UserController::class, 'editProfile']);
    Route::get('{uuid}', [UserController::class, 'getOtherProfile']);
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('reset', [AuthController::class, 'resetPassword']);
    Route::post('reset/send-mail', [AuthController::class, 'sendMailResetPassword']);
});
