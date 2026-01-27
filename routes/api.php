<?php

use App\Http\Controllers\JadiBackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => '/post'], function () {
    Route::post('/comment', [JadiBackendController::class, 'submitComment'])->name('comment.submit');
});
