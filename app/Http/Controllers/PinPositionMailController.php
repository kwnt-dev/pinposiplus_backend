<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendPinPositionMailRequest;
use App\Mail\PinPositionMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PinPositionMailController extends Controller
{
    // ピン位置表PDFをメール送信
    public function send(SendPinPositionMailRequest $request)
    {
        $validated = $request->validated();

        try {
            Mail::to($validated['to'])->send(
                new PinPositionMail($validated['date'], $validated['pdf_url'])
            );

            Log::info('ピン位置表メール送信成功', [
                'to' => $validated['to'],
                'date' => $validated['date'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'メールを送信しました',
            ]);
        } catch (\Exception $e) {
            Log::error('ピン位置表メール送信失敗', [
                'to' => $validated['to'],
                'date' => $validated['date'],
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'メール送信に失敗しました',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
