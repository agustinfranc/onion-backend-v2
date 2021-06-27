<?php

namespace Tests\E2E;

use App\Models\Commerce;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;

class ShowCommerceTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_commerce_unauthenticated()
    {
        $commerce = Commerce::factory()->create();


        $response = $this->get('/api/' . $commerce->name);


        $this->assertGuest($guard = null);

        $response->assertStatus(200)
            ->assertJsonStructure(
                array_merge(
                    array_keys($commerce->toArray()),
                    ['rubros', 'currency']
                )
            )
            ->assertJsonPath('name', $commerce->name);
    }

    public function test_show_commerces_unauthenticated()
    {
        $commerces = Commerce::factory()->count(2)->create();


        $response = $this->get('/api/commerces');


        $this->assertGuest($guard = null);

        $response->assertOk()
            ->assertJsonStructure([
                '*' => array_keys($commerces[0]->toArray())
            ])
            ->assertJsonPath('0.name', $commerces[0]->name)
            ->assertJsonPath('1.name', $commerces[1]->name);
    }

    public function test_show_commerce_authenticated()
    {
        $commerce = Commerce::factory()->create();
        $user = User::factory()->create();

        $commerce->users()->attach($user->id);


        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/auth/commerces/' . $commerce->id);


        $this->assertAuthenticated('sanctum');

        $response->assertStatus(200)
            ->assertJsonStructure(array_keys($commerce->toArray()))
            ->assertJsonPath('name', $commerce->name);
    }

    public function test_show_commerces_authenticated()
    {
        $commerces = Commerce::factory()->count(2)->create();

        $user = User::factory()->create();

        $commerces[0]->users()->attach($user->id);
        $commerces[1]->users()->attach($user->id);


        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/auth/commerces');


        $this->assertAuthenticated('sanctum');

        $response->assertOk()
            ->assertJsonStructure([
                '*' => array_keys($commerces[0]->toArray())
            ])
            ->assertJsonPath('0.name', $commerces[0]->name)
            ->assertJsonPath('1.name', $commerces[1]->name);
    }

    public function test_commerce_not_found()
    {
        $fakeCommerceName = 'fake-name';


        $response = $this->get('/api/' . $fakeCommerceName);


        $this->assertGuest($guard = null);

        $response->assertStatus(404);
    }

    public function test_cannot_show_commerce_authenticated()
    {
        $commerce = Commerce::factory()->create();

        $user = User::factory()->create();


        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/auth/commerces/' . $commerce->id);


        $this->assertAuthenticated('sanctum');

        $response->assertStatus(404);
    }
}