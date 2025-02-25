<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::apiResource('guests', \App\Http\Controllers\API\GuestController::class);

Route::apiResource('rooms', \App\Http\Controllers\API\RoomController::class);

Route::get('/reservations', [\App\Http\Controllers\API\ReservationController::class, 'index']);
Route::post('/reservations', [\App\Http\Controllers\API\ReservationController::class, 'store']);
