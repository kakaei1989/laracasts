<?php

use App\Http\Controllers\API\v1\AnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\ThreadController;

Route::resource('threads', ThreadController::class);
Route::prefix('threads')->group(function () {
    Route::resource('answers', AnswerController::class);
});
