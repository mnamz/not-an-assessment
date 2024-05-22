<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProcessOrder;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Items endpoints
 */
Route::get('/items', [ItemController::class, 'index']);

/**
 * Restaurants endpoints
 */
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurant/{id}', [RestaurantController::class, 'get']);

/**
 * Process Order
 */
Route::post('/process-order', ProcessOrder::class);

/**
 *  User endpoint
 */
Route::get('/users', [UserController::class, 'index']);

