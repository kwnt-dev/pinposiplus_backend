<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

public function login(Request $request)
{
    // 1. バリデーション
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. 認証
    if (Auth::attempt($validated)) {
        // 3. 認証成功：セッション再生成
        $request->session()->regenerate();
        return response()->json(Auth::user());
    }

    // 4. 認証失敗
    return response()->json(['message' => 'ログイン失敗'], 401);
}

}