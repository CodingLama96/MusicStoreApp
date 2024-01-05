<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser()
{
    $password = 'password123';
    $userData = [
        'name' => 'User',
        'email' => 'User@gmail.com',
        'password' => $password,
        'password_confirmation' => $password,
        'role' => 'user',
    ];

    $response = $this->postJson('/register', $userData);

    $expected = [
        'message' => 'User registered successfully',
        'user' => [
            'name' => 'User',
            'email' => 'User@gmail.com',
            'role' => 'user',
        ],
    ];

    $response->assertStatus(201)
        ->assertJson($expected);
}

public function testLoginUser()
{
    $user = User::create([
        'name' => 'User',
        'email' => 'User@gmail.com',
        'password' => bcrypt('password123'),
    ]);

    $loginData = [
        'email' => $user->email,
        'password' => 'password123',
    ];

    $response = $this->postJson('/login', $loginData);

    $expected = [
        'user' => [
            'name' => 'User',
            'email' => 'User@gmail.com',
            'role' => 'user',
        ],
    ];

    // Retrieve the token from the actual response
    $actualToken = json_decode($response->getContent(), true)['token'];

    $expected['token'] = $actualToken;

    $response->assertStatus(200)
        ->assertJson($expected);
}


public function testGetUserData()
{
    $user = User::create([
        'name' => 'User',
        'email' => 'User@gmail.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->getJson('/user');

    $expected = [
        'user' => [
            'name' => 'User',
            'email' => 'User@gmail.com',
            'role' => 'user',
        ],
    ];

    $response->assertStatus(200)
        ->assertJson($expected);
}


  
}
