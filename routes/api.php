<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\RidersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Seasons routes
Route::get('/seasons', [SeasonController::class, 'index']);
Route::get('/seasons/{id}', [SeasonController::class, 'show']);
Route::post('/seasons', [SeasonController::class, 'store']);
Route::put('/seasons/{id}', [SeasonController::class, 'update']);
Route::delete('/seasons/{id}', [SeasonController::class, 'destroy']);

// Rider routes
Route::get('/riders', [RidersController::class, 'index']);
Route::get('/riders/{id}', [RidersController::class, 'show']);
Route::post('/riders', [RidersController::class, 'store']);
Route::put('/riders/{id}', [RidersController::class, 'update']);
Route::delete('/riders/{id}', [RidersController::class, 'destroy']);
// Team routes

// Race routes

// Result routes

// RiderTeam routes