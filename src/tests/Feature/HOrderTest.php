<?php

namespace Tests\Feature;

use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HOrderTest extends TestCase
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
    public function get_order()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/orders');
        $response->assertStatus(200);
    }

    /** @test */
    public function store_order()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);
        $cart = new CartRepository();
        $cart->storeCart();
        CartItem::create([
            'product_id' => 1,
            'quantity' => 2,
            'unitPrice' => 20,
            'cart_id' => $cart->getCart()->id
        ]);
        $request = [
            'address_id' => 1,
            'coupon_id' => 1
        ];

        $response = $this->postJson('/api/orders', $request);
        $response->assertStatus(201);
    }

    /** @test */
    public function get_order_by_id()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/orders/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function update_order()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'status' => 'PROCESSING'
        ];

        $response = $this->patchJson('/api/orders/1', $request);
        $response->assertStatus(200);
    }

    /** @test */
    public function cancel_order()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);


        $response = $this->deleteJson('/api/orders/1');
        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_store_order()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);
        $request = [
            'address_id' => "abc",
            'coupon_id' => false
        ];

        $response = $this->postJson('/api/orders', $request);
        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_get_order_by_id()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/orders/1000');
        $response->assertStatus(404);
    }

    /** @test */
    public function unauthorized_to_get_order_by_id()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/orders/1');
        $response->assertStatus(403);
    }

    /** @test */
    public function fail_to_update_order()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'status' => 'INVALID_STATUS'
        ];

        $response = $this->patchJson('/api/orders/1', $request);
        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_cancel_order()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);


        $response = $this->deleteJson('/api/orders/10000');
        $response->assertStatus(404);
    }
}
