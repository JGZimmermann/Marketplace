<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GCartTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => 'senha123'
        ]);
    }
    /** @test */
    public function get_cart()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/cart');
        $response->assertStatus(200);
    }

    /** @test */
    public function create_cart()
    {
        Sanctum::actingAs($this->user);

        $response = $this->post('/api/cart');
        $response->assertStatus(200);
    }

    /** @test */
    public function create_cart_item()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();

        $request = [
            'product_id' => 1,
            'quantity' => 2
        ];

        $response = $this->postJson('/api/cart/items', $request);
        $response->assertStatus(204);
    }

    /** @test */
    public function get_cart_items()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();
        $this->create_cart_item();

        $response = $this->getJson('/api/cart/items');
        $response->assertStatus(200);
    }

    /** @test */
    public function update_cart_items()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();
        $this->create_cart_item();

        $request = [
            'product_id' => 1,
            'quantity' => 3
        ];

        $response = $this->patchJson('/api/cart/items', $request);
        $response->assertStatus(200);
    }

    /** @test */
    public function delete_cart_items()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();
        $this->create_cart_item();

        $request = [
            'product_id' => 1
        ];

        $response = $this->deleteJson('/api/cart/items', $request);
        $response->assertStatus(204);
    }

    /** @test */
    public function clear_cart()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();
        $this->create_cart_item();

        $response = $this->deleteJson('/api/cart/clear');
        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_create_cart()
    {
        Sanctum::actingAs($this->user);
        $this->create_cart();

        $response = $this->postJson('/api/cart');
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Usuário já possui um carrinho'
            ]);
    }

    /** @test */
    public function fail_to_update_cart_items()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();
        $this->create_cart_item();

        $request = [
            'product_id' => "abc",
            'quantity' => "vsvdf"
        ];

        $response = $this->patchJson('/api/cart/items', $request);
        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_create_cart_item()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();

        $request = [
            'product_id' => "true",
            'quantity' => false
        ];

        $response = $this->postJson('/api/cart/items', $request);
        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_delete_cart_items()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);
        Sanctum::actingAs($user);

        $this->create_cart();
        $this->create_cart_item();

        $request = [
            'product_id' => "true"
        ];

        $response = $this->deleteJson('/api/cart/items', $request);
        $response->assertStatus(422);
    }
}
