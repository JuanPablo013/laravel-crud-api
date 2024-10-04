<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;

Route::get('/players', [PlayerController::class, 'index']);

Route::get('/players/{id}', [PlayerController::class, 'show']);

Route::post('/players', [PlayerController::class, 'store']);

Route::put('/players/{id}', [PlayerController::class, 'update']);

Route::patch('/players/{id}', [PlayerController::class, 'updatePartial']);

Route::delete('/players/{id}', [PlayerController::class, 'destroy']);