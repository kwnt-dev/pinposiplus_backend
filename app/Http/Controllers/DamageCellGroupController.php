<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCellGroupRequest;
use App\Models\DamageCellGroup;

class DamageCellGroupController extends Controller
{
    public function index()
    {
        $query = DamageCellGroup::with('cells');

        if (request('hole_number')) {
            $query->where('hole_number', request('hole_number'));
        }

        return response()->json($query->get());
    }

    public function store(StoreCellGroupRequest $request)
    {
        $validated = $request->validated();

        $group = DamageCellGroup::create([
            'hole_number' => $validated['hole_number'],
            'comment' => $validated['comment'] ?? null,
        ]);

        foreach ($validated['cells'] as $cell) {
            $group->cells()->create([
                'hole_number' => $validated['hole_number'],
                'x' => $cell['x'],
                'y' => $cell['y'],
            ]);
        }

        return response()->json($group->load('cells'), 201);
    }

    public function destroy(string $id)
    {
        $group = DamageCellGroup::findOrFail($id);
        $group->delete();

        return response()->json(['message' => '削除しました']);
    }
}
