<?php

namespace App\Http\Controllers;

use App\Models\DailySchedule;
use Illuminate\Http\Request;

class DailyScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = DailySchedule::query();

        if ($request->date) {
            $query->where('date', $request->date);
        }

        $schedules = $query->orderBy('date', 'asc')->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:daily_schedules',
            'event_name' => 'required|string|max:255',
            'group_count' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $schedule = DailySchedule::create($validated);
        return response()->json($schedule, 201);
    }

    public function update(Request $request, string $id)
    {
        $schedule = DailySchedule::findOrFail($id);

        $validated = $request->validate([
            'date' => 'sometimes|date|unique:daily_schedules,date,' . $schedule->id,
            'event_name' => 'sometimes|string|max:255',
            'group_count' => 'sometimes|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);
        return response()->json($schedule);
    }

    public function destroy(string $id)
    {
        $schedule = DailySchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => '削除しました']);
    }
}