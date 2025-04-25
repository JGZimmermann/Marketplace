<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    /** @test */
    public function get_discounts()
    {
        $response = $this->getJson('/api/discounts');
        $response->assertStatus(200);
    }

    /** @test */
    public function create_discount()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "description" => "Teste",
            "startDate" => "2025-05-25",
            "endDate" => "2025-05-26",
            "discountPercentage" => 10,
            "product_id" => 1
        ];

        $response = $this->postJson('/api/discounts', $request);

        $response->assertStatus(201)
            ->assertJson([
                'description' => 'Teste'
            ]);
    }

    /** @test */
    public function get_discount_by_id()
    {
        $response = $this->getJson('/api/discounts/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function update_discount()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "description" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/discounts/1', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_discount()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/discounts/1');

        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_get_discount_by_id()
    {
        $response = $this->getJson('/api/discounts/45');
        $response->assertStatus(404);
    }

    /** @test */
    public function fail_to_create_discount()
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

        $response = $this->postJson('/api/discounts', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_update_discount()
    {
        $this->create_discount();
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "description" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/discounts/2', $request);

        $response->assertStatus(403);
    }

    /** @test */
    public function fail_to_delete_discount()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/discounts/2');

        $response->assertStatus(403);
    }
}
