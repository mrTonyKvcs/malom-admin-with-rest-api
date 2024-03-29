<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\WishController;

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
// Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

// Route::middleware('auth:api')->group(function () {
Route::resource('stores', StoreController::class);
Route::resource('events', EventController::class);
// Route::resource('wish', WishController::class);
// });
