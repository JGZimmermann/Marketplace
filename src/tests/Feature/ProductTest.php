<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function get_products()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
    }

    /** @test */
    public function create_product()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg');

        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => "Teste",
            "price" => 10,
            "stock" => 100.00,
            "category_id" => 1,
            "image_url" => $file
        ];

        $response = $this->postJson('/api/products', $request);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Teste'
            ]);
    }

    /** @test */
    public function get_product_by_id()
    {
        $response = $this->getJson('/api/products/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function update_product()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/products/1', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function update_stock()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "stock" => 40
        ];

        $response = $this->patchJson('/api/products/1/stock', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function delete_product()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/products/1');

        $response->assertStatus(204);
    }

    /** @test */
    public function fail_to_get_product_by_id()
    {
        $response = $this->getJson('/api/products/45');
        $response->assertStatus(404);
    }

    /** @test */
    public function fail_to_create_product()
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

        $response = $this->postJson('/api/products', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_update_product()
    {
        $this->create_product();
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "name" => "Teste atualizado"
        ];

        $response = $this->patchJson('/api/products/2', $request);

        $response->assertStatus(403);
    }

    /** @test */
    public function fail_to_update_product_stock()
    {
        $user = User::factory()->create([
            'password' => 'senha123',
            'role' => 'ADMIN'
        ]);

        Sanctum::actingAs($user);

        $request = [
            "stock" => 30
        ];

        $response = $this->patchJson('/api/products/5', $request);

        $response->assertStatus(422);
    }

    /** @test */
    public function fail_to_delete_product()
    {
        $user = User::factory()->create([
            'password' => 'senha123'
        ]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/products/2');

        $response->assertStatus(403);
    }
}
