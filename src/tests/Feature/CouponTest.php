<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CouponTest extends TestCase
{
    /** @test */
    public function get_coupons()
    {
        $response = $this->getJson('/api/coupons');
        $response->assertStatus(200);
    }

    /** @test */
    public function create_coupon()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "code" => "Teste",
            "startDate" => "2025-05-25",
            "endDate" => "2025-05-26",
            "discountPercentage" => 10,
            "product_id" => 1
        ];

        $response = $this->postJson('/api/coupons', $request);

        $response->assertStatus(201)
            ->assertJson([
                'code' => 'Teste'
            ]);
    }

    /** @test */
    public function get_coupon_by_id()
    {
        $response = $this->getJson('/api/coupons/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function update_coupon()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "code" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/coupons/1', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_coupon()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/coupons/1');

        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_get_coupon_by_id()
    {
        $response = $this->getJson('/api/coupons/45');
        $response->assertStatus(404);
    }

    /** @test */
    public function fail_to_create_coupon()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => 123,
            "description" => 0
        ];

        $response = $this->postJson('/api/coupons', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_update_coupon()
    {
        $this->create_coupon();
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "code" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/coupons/2', $request);

        $response->assertStatus(403);
    }

    /** @test */
    public function fail_to_delete_coupon()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/coupons/2');

        $response->assertStatus(403);
    }
}
