<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeasonController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Seasons routes
Route::get('/seasons', [SeasonController::class, 'index']);
Route::get('/seasons/{id}', [SeasonController::class, 'show']);
Route::post('/seasons', [SeasonController::class, 'store']);
Route::put('/seasons/{id}', [SeasonController::class, 'update']);
Route::delete('/seasons/{id}', [SeasonController::class, 'destroy']);

// Race routes

// Result routes

// Rider routes

// Team routes

// RiderTeam routes