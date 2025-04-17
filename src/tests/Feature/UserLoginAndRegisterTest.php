<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserLoginAndRegisterTest extends TestCase
{
    /** @test */
    public function create_user_successfully()
    {
        $request = [
            'name' => 'Teste Register',
            'email' => 'register@teste.com',
            'password' => 'Teste@123'
        ];

        $response = $this->postJson('/api/register', $request);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'email' => 'register@teste.com'
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'register@teste.com'
        ]);
    }

    /** @test */
    public function login_user_successufully()
    {
        $request = [
            'email' => 'register@teste.com',
            'password' => 'Teste@123'
        ];

        $response = $this->post('/api/login', $request);

        $response->assertStatus(200);
    }

    /** @test */
    public function error_register_user()
    {
        $request = [
            'name' => "",
            'email' => 'r',
            'password' => 'teste'
        ];

        $response = $this->postJson('/api/register', $request);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);

    }

    /** @test */
    public function error_register_user_already_exists()
    {
        $request = [
            'name' => 'Teste Register',
            'email' => 'register@teste.com',
            'password' => 'Teste@123'
        ];

        $response = $this->postJson('/api/register', $request);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'The email has already been taken.'
            ]);

    }

    /** @test */
    public function error_login_user()
    {
        $request = [
            'email' => 'teste@tiste.com',
            'password' => 'TESTE@321'
        ];

        $response = $this->postJson('/api/login', $request);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Credenciais Inválidas!'
            ]);
    }
}
