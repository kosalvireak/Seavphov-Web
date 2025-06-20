<?php

use App\Events\CreateAsset;
use App\Events\SendNotification;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast-notification', function () {
    event(new SendNotification(User::find(1)));
    return 'Sent notification!';
});

Route::get('/create-book', function () {
    event(new CreateAsset('book'));
    return 'Sent create book!';
});

Route::get('/create-discussion', function () {
    event(new CreateAsset('discussion'));
    return 'Sent create discussion!';
});

Route::get('/create-community', function () {
    event(new CreateAsset('community'));
    return 'Sent create community!';
});
