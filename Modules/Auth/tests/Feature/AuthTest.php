<?php

namespace Modules\Auth\Tests\Feature;

use Tests\TestCase;
use Modules\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_successfully()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Mojtaba',
            'email' => 'mojtaba@example.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_login_successfully()
    {
        $user = User::factory()->create([
            'email' => 'mojtaba@example.com',
            'password' => bcrypt('secret')
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'mojtaba@example.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_me_returns_user_data()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/v1/me');

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => $user->email]);
    }

    public function test_logout_successfully()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/v1/logout');

        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Successfully logged out']);
    }

    public function test_refresh_token()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/v1/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
}
