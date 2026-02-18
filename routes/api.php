<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoSuggestController;
use App\Http\Controllers\BanCellController;
use App\Http\Controllers\DailyScheduleController;
use App\Http\Controllers\DamageCellController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\PinHistoryController;
use App\Http\Controllers\PinPositionMailController;
use App\Http\Controllers\PinSessionController;
use App\Http\Controllers\RainCellController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

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

    // 自動提案データ（全員）
    Route::get('/auto-suggest-data', [AutoSuggestController::class, 'index']);

    // セッション（参照は全員）
    Route::get('/pin-sessions', [PinSessionController::class, 'index']);
    Route::get('/pin-sessions/{id}', [PinSessionController::class, 'show']);

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

        // メール送信
        Route::post('/send-pin-position-email', [PinPositionMailController::class, 'send']);

        // セッション管理
        Route::post('/pin-sessions', [PinSessionController::class, 'store']);
        Route::put('/pin-sessions/{id}', [PinSessionController::class, 'update']);
        Route::delete('/pin-sessions/{id}', [PinSessionController::class, 'destroy']);
        Route::patch('/pin-sessions/{id}/check', [PinSessionController::class, 'check']);
        Route::patch('/pin-sessions/{id}/publish', [PinSessionController::class, 'publish']);
        Route::patch('/pin-sessions/{id}/confirm', [PinSessionController::class, 'confirm']);
        Route::patch('/pin-sessions/{id}/approve', [PinSessionController::class, 'approve']);
        Route::patch('/pin-sessions/{id}/send', [PinSessionController::class, 'send']);
    });
});
