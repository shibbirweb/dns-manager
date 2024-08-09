<?php

use App\Http\Controllers\API\MagicLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('magic-token/verify', [MagicLoginController::class, 'verifyMagicToken']);
});
