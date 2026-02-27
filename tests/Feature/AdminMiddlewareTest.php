<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_staffはadmin専用エンドポイントに403(): void
    {
        $staff = User::factory()->create();

        $this->actingAs($staff)->getJson('/api/users')->assertStatus(403);
        $this->actingAs($staff)->postJson('/api/pin-sessions', ['course' => 'OUT'])->assertStatus(403);
    }

    public function test_adminはadmin専用エンドポイントにアクセス可能(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->getJson('/api/users')->assertStatus(200);
    }

    public function test_未認証は全保護ルートに401(): void
    {
        $this->getJson('/api/me')->assertStatus(401);
        $this->getJson('/api/pins?hole_number=1')->assertStatus(401);
        $this->getJson('/api/pin-sessions')->assertStatus(401);
    }
}
