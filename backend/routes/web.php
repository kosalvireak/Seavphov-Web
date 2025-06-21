<?php

use App\Events\CreateAsset;
use App\Events\SendNotification;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast/{id}', function ($id) {
    $user = User::where('id', $id)->first();
    if ($user != null) {
        event(new SendNotification($user));
    }
    return 'Sent notification!' . $id;
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
