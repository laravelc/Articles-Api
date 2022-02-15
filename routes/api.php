<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\ClientApplicationController;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

//Protecting Routes
Route::group(['middleware' => ['api', 'auth.apikey']], function () {
    Route::resource('article', ArticleController::class, [
        'only' => ['create', 'update', 'destroy', 'show'],
    ]);

    Route::post('article', [ArticleController::class, 'store']);

    Route::prefix('article/{id}')->group(function () {
        Route::get('/authors', [AuthorController::class, 'show']);
        Route::put('/authors', [AuthorController::class, 'update']);
        Route::delete('/authors', [AuthorController::class, 'destroy']);
    });

    Route::get('/app', [ClientApplicationController::class, 'show']);
});
