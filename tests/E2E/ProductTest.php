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
        $product = Product::factory()->create();
        $user = User::factory()->create();


        $response = $this->actingAs($user, 'sanctum')
            ->get('/api/auth/products/' . $product->id);


        $this->assertAuthenticated('sanctum');

        $response->assertOk()
            ->assertJson($product->toArray());
    }
}