<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout']);

Route::get('user/{user}/orders', [App\Http\Controllers\UserController::class, 'showOrdersOfUser'])->name('user.orders');
Route::apiResource('user', App\Http\Controllers\UserController::class)->only([
    'index', 'show', 'store'
]);