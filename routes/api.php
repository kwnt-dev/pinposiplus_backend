<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DamageCellController;
use App\Http\Controllers\BanCellController;
use App\Http\Controllers\RainCellController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

     // セル
    Route::get('/damage-cells', [DamageCellController::class, 'index']);
    Route::post('/damage-cells', [DamageCellController::class, 'store']);
    Route::delete('/damage-cells/{id}', [DamageCellController::class, 'destroy']);

    Route::get('/ban-cells', [BanCellController::class, 'index']);
    Route::post('/ban-cells', [BanCellController::class, 'store']);
    Route::delete('/ban-cells/{id}', [BanCellController::class, 'destroy']);

    Route::get('/rain-cells', [RainCellController::class, 'index']);
    Route::post('/rain-cells', [RainCellController::class, 'store']);
    Route::delete('/rain-cells/{id}', [RainCellController::class, 'destroy']);
});