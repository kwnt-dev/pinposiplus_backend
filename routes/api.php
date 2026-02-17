<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoSuggestController;
use App\Http\Controllers\BanCellController;
use App\Http\Controllers\DailyScheduleController;
use App\Http\Controllers\DamageCellController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\PinHistoryController;
use App\Http\Controllers\PinPositionMailController;
use App\Http\Controllers\RainCellController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/auto-suggest-data', [AutoSuggestController::class, 'index']);
    Route::post('/send-pin-position-email', [PinPositionMailController::class, 'send']);

    // ピン（全員）
    Route::get('/pins', [PinController::class, 'index']);
    Route::post('/pins', [PinController::class, 'store']);
    Route::delete('/pins/{id}', [PinController::class, 'destroy']);

    // ピン履歴（全員）
    Route::get('/pin-histories', [PinHistoryController::class, 'index']);

    // セル・スケジュール（参照は全員）
    Route::get('/damage-cells', [DamageCellController::class, 'index']);
    Route::get('/ban-cells', [BanCellController::class, 'index']);
    Route::get('/rain-cells', [RainCellController::class, 'index']);
    Route::get('/schedules', [DailyScheduleController::class, 'index']);

    // admin専用
    Route::middleware('admin')->group(function () {
        // ユーザー管理
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // セル編集
        Route::post('/damage-cells', [DamageCellController::class, 'store']);
        Route::delete('/damage-cells/{id}', [DamageCellController::class, 'destroy']);
        Route::post('/ban-cells', [BanCellController::class, 'store']);
        Route::delete('/ban-cells/{id}', [BanCellController::class, 'destroy']);
        Route::post('/rain-cells', [RainCellController::class, 'store']);
        Route::delete('/rain-cells/{id}', [RainCellController::class, 'destroy']);

        // スケジュール編集
        Route::post('/schedules', [DailyScheduleController::class, 'store']);
        Route::put('/schedules/{id}', [DailyScheduleController::class, 'update']);
        Route::delete('/schedules/{id}', [DailyScheduleController::class, 'destroy']);
    });
});
