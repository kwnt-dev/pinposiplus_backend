<?php

namespace App\Http\Controllers;

use App\Models\PinHistory;
use Illuminate\Http\Request;

class PinHistoryController extends Controller
{
    // ピン履歴一覧（ホール番号・日付でフィルタ可）
    public function index(Request $request)
    {
        $query = PinHistory::query();

        if ($request->hole_number) {
            $query->where('hole_number', $request->hole_number);
        }

        if ($request->date) {
            $query->where('date', $request->date);
        }

        $histories = $query->with('submitter:id,name')->orderBy('date', 'desc')->get();

        return response()->json($histories);
    }
}
