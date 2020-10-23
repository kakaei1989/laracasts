<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    include __DIR__ . '\v1\auth_routes.php';
    include __DIR__ . '\v1\channels.php';
});
