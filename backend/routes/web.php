<?php

use App\Events\MessageSent;
use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast', function () {
    broadcast(new MessageSent('Hello from Seavphov'));
    return 'Message Broadcasted';
});
