<?php

namespace Tests\E2E;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create();


        $response = $this->post('/api/token', ['email' => $user->email, 'password' => 'password']);


        $response->assertOk()
            ->assertJsonStructure(
                array_merge(
                    array_keys($user->toArray()),
                    ['commerces', 'token']
                )
            )
            ->assertJsonFragment(
                $user->toArray()
            );
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();


        $response = $this->actingAs($user, 'sanctum')
            ->post('/api/auth/logout');


        $this->assertAuthenticated('sanctum');

        $response->assertOk();
    }

    public function test_show_user_authenticated()
    {
        $user = User::factory()->create();


        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/auth/me');


        $this->assertAuthenticated('sanctum');

        $response->assertOk()
            ->assertJsonStructure(
                array_merge(
                    array_keys($user->toArray()),
                    ['commerces', 'token']
                )
            )
            ->assertJsonFragment(
                $user->toArray()
            );
    }

    public function test_user_cannot_login_for_invalid_credentials()
    {
        $user = User::factory()->create();


        $response = $this->post('/api/token', ['email' => $user->email, 'password' => 'pass']);


        $response->assertStatus(401)
            ->assertJson(["error" => "Usuario y/o contraseña incorrectos"]);
    }

    public function test_user_is_not_authenticated()
    {
        $response = $this->getJson('/api/auth/me');


        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}