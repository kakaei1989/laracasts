<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\ThreadController;

Route::resource('threads', ThreadController::class);
