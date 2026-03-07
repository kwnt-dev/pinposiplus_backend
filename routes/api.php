<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoSuggestController;
use App\Http\Controllers\CellController;
use App\Http\Controllers\CellGroupController;
use App\Http\Controllers\DailyScheduleController;
use App\Http\Controllers\DemoResetController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\PinHistoryController;
use App\Http\Controllers\PinPositionMailController;
use App\Http\Controllers\PinSessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/demo-reset', [DemoResetController::class, 'reset']);

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
    Route::get('/{type}-cells', [CellController::class, 'index'])->whereIn('type', ['damage', 'ban', 'rain']);
    Route::get('/schedules', [DailyScheduleController::class, 'index']);

    // セルグループ（参照は全員）
    Route::get('/{type}-cell-groups', [CellGroupController::class, 'index'])->whereIn('type', ['damage', 'ban', 'rain']);

    // 自動提案データ（全員）
    Route::get('/auto-suggest-data', [AutoSuggestController::class, 'index']);

    // セッション（参照は全員）
    Route::get('/pin-sessions', [PinSessionController::class, 'index']);
    Route::get('/pin-sessions/{id}', [PinSessionController::class, 'show']);

    // セッション確認提出（staff + admin）
    Route::patch('/pin-sessions/{id}/confirm', [PinSessionController::class, 'confirm']);

    // admin専用
    Route::middleware('admin')->group(function () {
        // ユーザー管理
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // セル編集
        Route::post('/{type}-cells', [CellController::class, 'store'])->whereIn('type', ['damage', 'ban', 'rain']);
        Route::delete('/{type}-cells/{id}', [CellController::class, 'destroy'])->whereIn('type', ['damage', 'ban', 'rain']);

        // セルグループ編集
        Route::post('/{type}-cell-groups', [CellGroupController::class, 'store'])->whereIn('type', ['damage', 'ban', 'rain']);
        Route::delete('/{type}-cell-groups/{id}', [CellGroupController::class, 'destroy'])->whereIn('type', ['damage', 'ban', 'rain']);

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
        Route::patch('/pin-sessions/{id}/publish', [PinSessionController::class, 'publish']);
        Route::patch('/pin-sessions/{id}/send', [PinSessionController::class, 'send']);
    });
});
