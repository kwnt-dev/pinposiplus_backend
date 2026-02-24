<?php

namespace App\Http\Controllers;

use App\Models\PinHistory;
use App\Models\PinSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PinSessionController extends Controller
{
    /**
     * ステータス遷移ルール
     * key: 遷移先, value: 許可される遷移元
     */
    private const STATUS_TRANSITIONS = [
        'published' => 'draft',
        'confirmed' => 'published',
        'approved' => 'confirmed',
        'sent' => 'approved',
    ];

    /**
     * ステータス遷移バリデーション
     */
    private function validateTransition(PinSession $session, string $nextStatus): ?JsonResponse
    {
        $expectedCurrent = self::STATUS_TRANSITIONS[$nextStatus] ?? null;

        if ($expectedCurrent && $session->status !== $expectedCurrent) {
            return response()->json([
                'message' => "ステータスを {$session->status} から {$nextStatus} に変更できません（現在のステータスが {$expectedCurrent} である必要があります）",
            ], 422);
        }

        return null;
    }

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
            'status' => 'nullable|in:draft,published,confirmed,approved,sent',
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

    public function publish(string $id): JsonResponse
    {
        $session = PinSession::findOrFail($id);

        if ($error = $this->validateTransition($session, 'published')) {
            return $error;
        }

        $session->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json($session);
    }

    public function confirm(Request $request, string $id): JsonResponse
    {
        $session = PinSession::findOrFail($id);

        if ($error = $this->validateTransition($session, 'confirmed')) {
            return $error;
        }

        $user = $request->user();

        $session->update([
            'status' => 'confirmed',
            'submitted_at' => now(),
            'submitted_by' => $user->id,
            'submitted_by_name' => $user->name,
        ]);

        return response()->json($session);
    }

    public function approve(Request $request, string $id): JsonResponse
    {
        $session = PinSession::findOrFail($id);

        if ($error = $this->validateTransition($session, 'approved')) {
            return $error;
        }

        $session->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->name,
        ]);

        return response()->json($session);
    }

    public function send(string $id): JsonResponse
    {
        $session = PinSession::findOrFail($id);

        if ($error = $this->validateTransition($session, 'sent')) {
            return $error;
        }

        $this->savePinsToHistory($session);

        $session->update([
            'status' => 'sent',
        ]);

        return response()->json($session);
    }

    private function savePinsToHistory(PinSession $session): void
    {
        $targetDate = $session->target_date
            ? date('Y-m-d', strtotime($session->target_date))
            : date('Y-m-d');

        $pins = $session->pins;

        foreach ($pins as $pin) {
            PinHistory::where('hole_number', $pin->hole_number)
                ->where('date', $targetDate)
                ->delete();

            PinHistory::create([
                'hole_number' => $pin->hole_number,
                'x' => $pin->x,
                'y' => $pin->y,
                'date' => $targetDate,
                'submitted_by' => $session->submitted_by,
            ]);
        }
    }
}
