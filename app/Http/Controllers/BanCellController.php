<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBanCellRequest;
use App\Models\BanCell;
use Illuminate\Http\Request;

class BanCellController extends Controller
{
    public function index(Request $request)
    {
        $cells = BanCell::where('hole_number', $request->hole_number)->get();

        return response()->json($cells);
    }

    public function store(StoreBanCellRequest $request)
    {
        $validated = $request->validated();

        $cell = BanCell::create($validated);

        return response()->json($cell, 201);
    }

    public function destroy(string $id)
    {
        $cell = BanCell::findOrFail($id);
        $cell->delete();

        return response()->json(['message' => '削除しました']);
    }
}
