<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyScheduleRequest;
use App\Http\Requests\UpdateDailyScheduleRequest;
use App\Models\DailySchedule;
use Illuminate\Http\Request;

class DailyScheduleController extends Controller
{
    // スケジュール一覧（日付・期間でフィルタ可）
    public function index(Request $request)
    {
        $query = DailySchedule::query();

        if ($request->date) {
            $query->where('date', $request->date);
        }

        if ($request->start_date) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('date', '<=', $request->end_date);
        }

        $schedules = $query->orderBy('date', 'asc')->get();

        return response()->json($schedules);
    }

    // スケジュール登録
    public function store(StoreDailyScheduleRequest $request)
    {
        $validated = $request->validated();
        $schedule = DailySchedule::create($validated);

        return response()->json($schedule, 201);
    }

    // スケジュール更新
    public function update(UpdateDailyScheduleRequest $request, string $id)
    {
        $schedule = DailySchedule::findOrFail($id);
        $validated = $request->validated();
        $schedule->update($validated);

        return response()->json($schedule);
    }

    // スケジュール削除
    public function destroy(string $id)
    {
        $schedule = DailySchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => '削除しました']);
    }
}
