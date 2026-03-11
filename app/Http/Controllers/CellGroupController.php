<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCellGroupRequest;
use App\Models\BanCellGroup;
use App\Models\DamageCellGroup;
use App\Models\RainCellGroup;
use Illuminate\Http\JsonResponse;

class CellGroupController extends Controller
{
    // セル種別（damage/ban/rain）とモデルの対応
    private const MODEL_MAP = [
        'damage' => DamageCellGroup::class,
        'ban' => BanCellGroup::class,
        'rain' => RainCellGroup::class,
    ];

    // URLのtype引数からモデルクラスを解決
    private function resolveModel(string $type): string
    {
        if (! isset(self::MODEL_MAP[$type])) {
            abort(404);
        }

        return self::MODEL_MAP[$type];
    }

    // セルグループ一覧（ホール番号でフィルタ可）
    public function index(string $type): JsonResponse
    {
        $model = $this->resolveModel($type);
        $query = $model::with('cells');

        if (request('hole_number')) {
            $query->where('hole_number', request('hole_number'));
        }

        return response()->json($query->get());
    }

    // セルグループ作成（グループ + 子セルを一括登録）
    public function store(StoreCellGroupRequest $request, string $type): JsonResponse
    {
        $model = $this->resolveModel($type);
        $validated = $request->validated();

        $group = $model::create([
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

    // セルグループ削除（子セルもカスケード削除）
    public function destroy(string $type, string $id): JsonResponse
    {
        $model = $this->resolveModel($type);
        $group = $model::findOrFail($id);
        $group->delete();

        return response()->json(['message' => '削除しました']);
    }
}
