<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StarbucksCrawlerController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/posts', [PostController::class, 'index']);

Route::get('/crawl-starbucks', [StarbucksCrawlerController::class, 'fetch']);