<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\ChannelController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('auth.user');
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::prefix('/channel')->group(function () {
        Route::post('/create', [ChannelController::class, 'createNewChannel'])->name('channel.create');
        Route::get('/all', [ChannelController::class, 'getAllChannels'])->name('channel.all');
        Route::put('/update', [ChannelController::class, 'updateChannel'])->name('channel.update');
        Route::delete('/delete', [ChannelController::class, 'deleteChannel'])->name('channel.delete');
    });
});
