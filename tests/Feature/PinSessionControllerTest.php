<?php

namespace Tests\Feature;

use App\Models\Pin;
use App\Models\PinSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PinSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_セッション作成からpublishまでの正常遷移(): void
    {
        $admin = User::factory()->admin()->create();

        // 作成
        $response = $this->actingAs($admin)->postJson('/api/pin-sessions', [
            'course' => 'OUT',
            'target_date' => '2026-03-01',
        ]);
        $response->assertStatus(201)->assertJsonPath('status', 'draft');
        $sessionId = $response->json('id');

        // draft → published
        $this->actingAs($admin)
            ->patchJson("/api/pin-sessions/{$sessionId}/publish")
            ->assertStatus(200)
            ->assertJsonPath('status', 'published');
    }

    public function test_不正なステータス遷移は拒否される(): void
    {
        $admin = User::factory()->admin()->create();
        $session = PinSession::factory()->create(['status' => 'draft']);

        // draft → confirmed（publishを飛ばし）は不可
        $this->actingAs($admin)
            ->patchJson("/api/pin-sessions/{$session->id}/confirm")
            ->assertStatus(422);

        // draft → sent も不可
        $this->actingAs($admin)
            ->patchJson("/api/pin-sessions/{$session->id}/send")
            ->assertStatus(422);
    }

    public function test_send時にピン履歴が保存される(): void
    {
        Mail::fake();
        $admin = User::factory()->admin()->create();

        $session = PinSession::factory()->create([
            'status' => 'confirmed',
            'target_date' => '2026-03-01',
            'submitted_by' => $admin->id,
        ]);
        Pin::factory()->create([
            'session_id' => $session->id,
            'hole_number' => 1,
            'x' => 100,
            'y' => 200,
        ]);

        $this->actingAs($admin)
            ->patchJson("/api/pin-sessions/{$session->id}/send")
            ->assertStatus(200)
            ->assertJsonPath('status', 'sent');

        $this->assertDatabaseHas('pin_history', [
            'hole_number' => 1,
            'x' => 100,
            'y' => 200,
            'date' => '2026-03-01',
        ]);
    }
}
