<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_bearer_token(): void
    {
        User::create([
            'name' => 'API Tester',
            'username' => 'apitester',
            'email' => 'api@example.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'api@example.test',
            'password' => 'password123',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => ['user', 'token'],
            ]);
    }

    public function test_protected_api_requires_token(): void
    {
        $this->getJson('/api/v1/me')
            ->assertUnauthorized()
            ->assertJsonPath('success', false);
    }

    public function test_bearer_token_can_access_current_user_endpoint(): void
    {
        User::create([
            'name' => 'API Tester',
            'username' => 'apitester',
            'email' => 'api@example.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $token = $this->postJson('/api/v1/login', [
            'email' => 'api@example.test',
            'password' => 'password123',
        ])->json('data.token');

        $this->withToken($token)
            ->getJson('/api/v1/me')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.email', 'api@example.test');
    }
}
