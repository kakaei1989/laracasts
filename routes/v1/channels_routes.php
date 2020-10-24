<?php

use App\Http\Controllers\API\v1\ChannelController;
use Illuminate\Support\Facades\Route;

Route::prefix('/channel')->group(function () {
    Route::get('/all', [ChannelController::class, 'getAllChannels'])->name('channel.all');
    Route::prefix('/channel')->middleware(['can:channel management', 'auth:sanctum'])->group(function () {
        Route::post('/create', [ChannelController::class, 'createNewChannel'])->name('channel.create');
        Route::put('/update', [ChannelController::class, 'updateChannel'])->name('channel.update');
        Route::delete('/delete', [ChannelController::class, 'deleteChannel'])->name('channel.delete');
    });
});
