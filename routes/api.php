<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RiderTeamController;
use App\Http\Controllers\ResultController;

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
Route::get('/races', [RaceController::class, 'index']);
Route::get('/races/{id}', [RaceController::class, 'show']);
Route::post('/races', [RaceController::class, 'store']);
Route::put('/races/{id}', [RaceController::class, 'update']);
Route::delete('/races/{id}', [RaceController::class, 'destroy']);

// RiderTeam routes
Route::get('/ridersTeams', [RiderTeamController::class, 'index']);
Route::get('/ridersTeams/{id}', [RiderTeamController::class, 'show']);
Route::post('/ridersTeams', [RiderTeamController::class, 'store']);
Route::put('/ridersTeams/{id}', [RiderTeamController::class, 'update']);
Route::delete('/ridersTeams/{id}', [RiderTeamController::class, 'destroy']);

// Routes routes
Route::get('/results', [ResultController::class, 'index']);
Route::get('/results/{id}', [ResultController::class, 'show']);
Route::post('/results', [ResultController::class, 'store']);
Route::put('/results/{id}', [ResultController::class, 'update']);
Route::delete('/results/{id}', [ResultController::class, 'destroy']);