<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\TeamController;

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
Route::get('/riders', [RiderController::class, 'index']);
Route::get('/riders/{id}', [RiderController::class, 'show']);
Route::post('/riders', [RiderController::class, 'store']);
Route::put('/riders/{id}', [RiderController::class, 'update']);
Route::delete('/riders/{id}', [RiderController::class, 'destroy']);

// Team routes
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/teams/{id}', [TeamController::class, 'show']);
Route::post('/teams', [TeamController::class, 'store']);
Route::put('/teams/{id}', [TeamController::class, 'update']);
Route::delete('/teams/{id}', [TeamController::class, 'destroy']);
// Race routes

// Result routes

// RiderTeam routes