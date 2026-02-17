<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRainCellRequest;
use App\Models\RainCell;
use Illuminate\Http\Request;

class RainCellController extends Controller
{
    public function index(Request $request)
    {
        $cells = RainCell::where('hole_number', $request->hole_number)->get();

        return response()->json($cells);
    }

    public function store(StoreRainCellRequest $request)
    {
        $validated = $request->validated();

        $cell = RainCell::create($validated);

        return response()->json($cell, 201);
    }

    public function destroy(string $id)
    {
        $cell = RainCell::findOrFail($id);
        $cell->delete();

        return response()->json(['message' => '削除しました']);
    }
}
