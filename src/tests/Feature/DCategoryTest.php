<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DCategoryTest extends TestCase
{
    /** @test */
    public function get_categories()
    {
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
    }


    /** @test */
    public function create_category()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => "Teste",
            "description" => "Teste automático para a categoria"
        ];

        $response = $this->postJson('/api/categories', $request);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Teste'
            ]);
    }

    /** @test */
    public function get_category_by_id()
    {
        $response = $this->getJson('/api/categories/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function update_category()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/categories/1', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_category()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $this->create_category();
        $response = $this->delete('/api/categories/2');

        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_get_category_by_id()
    {
        $response = $this->getJson('/api/categories/45');
        $response->assertStatus(404);
    }

    /** @test */
    public function fail_to_create_category()
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

        $response = $this->postJson('/api/categories', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_update_category()
    {
        $this->create_category();
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/categories/2', $request);

        $response->assertStatus(403);
    }

    /** @test */
    public function fail_to_delete_category()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/categories/3');

        $response->assertStatus(403);
    }
}
