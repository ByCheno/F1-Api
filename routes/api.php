<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Seasons routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/seasons', function(){
    return 'Lista de temporadas completa';
});

Route::get('/seasons/{id}', function($id){
    return 'Temporada ' . $id;
});

Route::post('/seasons', function(){
    return 'Temporada creada';
});

Route::put('/seasons/{id}', function($id){
    return 'Temporada ' . $id . ' actualizada';
});

Route::delete('/seasons/{id}', function($id){
    return 'Temporada ' . $id . ' eliminada';
});

// Race routes
// Result routes
// Rider routes
// Team routes
// RiderTeam routes