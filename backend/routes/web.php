<?php

use App\Events\CreateAsset;
use App\Events\SendNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast/{id}', function ($id) {
    event(new SendNotification(User::where('id', $id)->first()));
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