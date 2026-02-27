<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン成功でトークンが返る(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user' => ['id', 'name', 'email', 'role'], 'token'])
            ->assertJsonPath('user.role', 'admin');
    }

    public function test_パスワード不一致でログイン失敗(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    public function test_認証済みでユーザー情報取得(): void
    {
        $user = User::factory()->create(['role' => 'staff']);

        $this->actingAs($user)->getJson('/api/me')
            ->assertStatus(200)
            ->assertJsonPath('role', 'staff');
    }

    public function test_未認証でユーザー情報取得は401(): void
    {
        $this->getJson('/api/me')->assertStatus(401);
    }
}
