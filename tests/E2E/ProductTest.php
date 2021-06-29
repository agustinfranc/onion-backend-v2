<?php

namespace Tests\E2E;

use App\Models\Commerce;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_product()
    {
        $user = User::factory()->create();
        $commerce = Commerce::factory()->create();
        $product = Product::factory()->create([
            'commerce_id' => $commerce->id,
        ]);

        $commerce->users()->attach($user->id);


        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/auth/products/' . $product->id);


        $this->assertAuthenticated('sanctum');

        $response->assertOk()
            ->assertJson($product->toArray());
    }

    public function test_create_product()
    {
        $commerce = Commerce::factory()->create();
        $user = User::factory()->create();
        $product = Product::factory()->make([
            'commerce_id' => $commerce->id,
            ])->toArray();

        $product['subrubro']['id'] = $product['subrubro_id'];

        $commerce->users()->attach($user->id);


        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/auth/commerces/' . $commerce->id . '/products', $product);


        $this->assertAuthenticated('sanctum');

        $response->assertCreated()
            ->assertJson($product);
    }
}