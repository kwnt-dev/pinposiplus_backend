<?php

namespace App\Http\Controllers;

use App\Models\PinHistory;
use Illuminate\Http\Request;

class PinHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PinHistory::query();

        if ($request->hole_number) {
            $query->where('hole_number', $request->hole_number);
        }

        if ($request->date) {
            $query->where('date', $request->date);
        }

        $histories = $query->orderBy('date', 'desc')->get();
        return response()->json($histories);
    }
}