<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AUserTest extends TestCase
{

    /** @test */
    public function get_logged_user()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/users/me');

        $response->assertStatus(200)
            ->assertJson([
                'email' => $user->email,
            ]);
    }

    /** @test */
    public function update_logged_user()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'name' => 'Tung Tung Sahur'
        ];

        $response = $this->patchJson('/api/users/me', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_logged_user()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/users/me');

        $response->assertStatus(204);
    }

    /** @test */
    public function create_moderator()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            'name' => 'Teste Automático',
            'email' => 'tung@sahur.com',
            'password' => 'TungTung@123'
        ];

        $response = $this->postJson('/api/users/create-moderator', $request);

        $response->assertStatus(201);
    }
}
