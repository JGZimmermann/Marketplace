<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CAddressTest extends TestCase
{
    /** @test */
    public function create_address()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'street' => 'Rua Teste da Silva',
            'number' => 100,
            'zip' => '000000-000',
            'city' => 'Teste',
            'state' => 'Teste',
            'country' => 'Teste'
        ];

        $response = $this->postJson('/api/addresses', $request);

        $response->assertStatus(201)
            ->assertJson([
                'city' => 'Teste'
            ]);
    }

    /** @test */
    public function get_address_by_user()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/addresses');

        $response->assertStatus(200);
    }

    /** @test */
    public function get_address_by_id()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/addresses/1');

        $response->assertStatus(200);
    }

    /** @test */
    public function update_address()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'number' => 666
        ];

        $response = $this->patchJson('/api/addresses/1', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_address()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $this->create_address();
        $response = $this->delete('/api/addresses/2');

        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_create_address()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'street' => 0,
            'number' => "100",
            'zip' => 0,
            'city' => 0.1,
            'state' => 'Teste',
            'country' => 'Teste'
        ];

        $response = $this->postJson('/api/addresses', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_find_address()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/addresses/12');

        $response->assertStatus(404);
    }

    /** @test */
    public function fail_to_update_address()
    {
        $this->create_address();
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'number' => "abc"
        ];

        $response = $this->patchJson('/api/addresses/3', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_delete_address()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $this->create_address();
        $response = $this->delete('/api/addresses/3');

        $response->assertStatus(403);
    }
}
