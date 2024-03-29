<?php

use App\Infrastructure\Http\Controllers\Index;
use App\Infrastructure\Http\Controllers\Url;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', [Index::class, 'get']);
    Route::get('/url', [Url::class, 'get']);
    Route::post('/url', [Url::class, 'post']);
});
