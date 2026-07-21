<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WebLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_simpleok_users_can_login_with_username_and_password(): void
    {
        $users = [
            ['username' => 'tppSimpleOk', 'password' => 'tpp123', 'role' => 'rekam_medis'],
            ['username' => 'kppSimpleOk', 'password' => 'kpp123', 'role' => 'perawat'],
            ['username' => 'dpjbSimpleOk', 'password' => 'dpjb123', 'role' => 'dokter'],
            ['username' => 'peranSimpleOk', 'password' => 'anestesi123', 'role' => 'anestesi'],
            ['username' => 'farmasiSimpleOk', 'password' => 'farmasi123', 'role' => 'farmasi'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['username'],
                'username' => $userData['username'],
                'email' => $userData['username'] . '@simrs.local',
                'password' => Hash::make($userData['password']),
                'role' => $userData['role'],
            ]);
        }

        foreach ($users as $userData) {
            $response = $this->post('/login', [
                'username' => $userData['username'],
                'password' => $userData['password'],
            ]);

            $response->assertRedirect('/dashboard');
        }
    }

    public function test_authenticated_user_can_logout_and_be_redirected_to_login(): void
    {
        $user = User::factory()->create([
            'username' => 'logoutuser',
            'email' => 'logoutuser@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'name' => 'Logout User',
        ]);

        $this->actingAs($user);

        $response = $this->get('/logout');

        $response->assertRedirect(route('login'));
        $this->assertNull(auth()->user());
    }
}
