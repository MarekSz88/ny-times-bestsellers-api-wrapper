<?php

use App\Http\Controllers\BestSellersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/best-sellers', [BestSellersController::class, 'index'])
    ->name('best-sellers.index');

/*
    TASK-COMMENT:
    by default we should always serve latest API version
    however assuming application grows and we need to introduce breaking changes
    we can open new endpoint for previous version.
    Preferably serving only old version of those urls which respoonse has changed to reduce complexity
    and maintainability of the code.
*/

Route::prefix('v1')->group(function () {
    Route::get('/best-sellers', [BestSellersController::class, 'v1_index']);
});

