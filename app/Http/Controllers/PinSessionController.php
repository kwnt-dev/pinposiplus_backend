<?php

namespace App\Http\Controllers;

use App\Models\PinSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PinSessionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = PinSession::query();

        if ($request->has('status')) {
            $status = $request->input('status');
            if (is_array($status)) {
                $query->whereIn('status', $status);
            } else {
                $query->where('status', $status);
            }
        }

        if ($request->has('course')) {
            $query->where('course', $request->course);
        }

        if ($request->has('target_date')) {
            $query->where('target_date', $request->target_date);
        }

        $sessions = $query->orderBy('updated_at', 'desc')->get();

        return response()->json($sessions);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'course' => 'required|in:OUT,IN',
            'target_date' => 'nullable|date',
            'event_name' => 'nullable|string',
            'groups_count' => 'nullable|integer',
            'is_rainy' => 'nullable|boolean',
        ]);

        $session = PinSession::create([
            ...$validated,
            'status' => 'draft',
            'target_date' => $validated['target_date'] ? date('Y-m-d', strtotime($validated['target_date'])) : null,
            'created_by' => $request->user()->id,
        ]);

        return response()->json($session, 201);
    }

    public function show(string $id): JsonResponse
    {
        $session = PinSession::with('pins')->findOrFail($id);

        return response()->json($session);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $session = PinSession::findOrFail($id);

        $validated = $request->validate([
            'event_name' => 'nullable|string',
            'groups_count' => 'nullable|integer',
            'status' => 'nullable|in:draft,checked,published,confirmed,approved,sent',
        ]);

        $session->update($validated);

        return response()->json($session);
    }

    public function destroy(string $id): JsonResponse
    {
        $session = PinSession::findOrFail($id);
        $session->delete();

        return response()->json(['message' => 'セッションを削除しました']);
    }
}
