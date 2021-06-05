<?php

namespace Tests\E2E;

use App\Models\Commerce;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;

class ShowCommerceTest extends TestCase
{
    private $_commerceStructure = [
        'id',
        'name',
        'fullname',
        'cover_dirname',
        'avatar_dirname',
        'whatsapp_number',
        'phone_number',
        'instagram_account',
        'facebook_account',
        'youtube_account',
        'tiktok_account',
        'maps_account',
        'dark_theme',
        'has_action_buttons',
        'has_footer',
        'currency_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function setUp(): void
    {
        parent::setUp();

        DB::beginTransaction();
    }

    public function tearDown(): void
    {
        DB::rollBack();

        parent::tearDown();
    }

    public function test_show_commerce_unauthenticated()
    {
        $commerce = Commerce::factory()->create();


        $response = $this->get('/api/' . $commerce->name);


        $this->assertGuest($guard = null);

        $response->assertStatus(200)
            ->assertJsonStructure(
                array_merge($this->_commerceStructure, [
                    'rubros',
                    'currency',
                ]))
            ->assertJsonPath('name', $commerce->name);
    }

    public function test_show_commerces_unauthenticated()
    {
        $commerce = Commerce::factory()->create();
        $commerce2 = Commerce::factory()->create();

        $response = $this->get('/api/commerces');


        $this->assertGuest($guard = null);

        $response->assertOk()
            ->assertJsonStructure([
                '*' => $this->_commerceStructure
            ])
            ->assertJsonPath('0.name', $commerce->name)
            ->assertJsonPath('1.name', $commerce2->name);
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
            ->assertJsonStructure($this->_commerceStructure)
            ->assertJsonPath('name', $commerce->name);
    }

    public function test_show_commerces_authenticated()
    {
        $commerce = Commerce::factory()->create();
        $commerce2 = Commerce::factory()->create();

        $user = User::factory()->create();

        $commerce->users()->attach($user->id);
        $commerce2->users()->attach($user->id);


        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/auth/commerces');


        $this->assertAuthenticated('sanctum');

        $response->assertOk()
            ->assertJsonStructure([
                '*' => $this->_commerceStructure
            ])
            ->assertJsonPath('0.name', $commerce->name)
            ->assertJsonPath('1.name', $commerce2->name);
    }
}