<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    // use RefreshDatabase;

    public function test_register_user_with_no_name() {
        $response = $this->postJson('/api/register', [
            'password' => '12345',
            'email' => 'test@mail.com',
        ]);

        $response->assertStatus(422);
    }

    public function test_register_user_with_no_email() {
        $response = $this->postJson('/api/register', [
            'password' => '12345',
            'name' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function test_register_user_with_no_password() {
        $response = $this->postJson('/api/register', [
            'email' => 'test@mail.com',
            'name' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function test_register_user() {
        $response = $this->postJson('/api/register', [
            'email' => 'test@mail.com',
            'password' => '12345',
            'name' => 'test'
        ]);

        $response->assertStatus(200);
    }

    public function test_register_user_with_same_email() {
        $response = $this->postJson('/api/register', [
            'email' => 'test@mail.com',
            'password' => '12345',
            'name' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function test_login_user() {
        $this->withoutExceptionHandling();
        
        $response = $this->postJson('/api/login', [
            'email' => 'test@mail.com',
            'password' => '12345'
        ]);

        $response->assertStatus(200);
    }

    // public function test_logout_user() {
    //     $this->actingAs(User::find(1), 'api');

    //     $this->withoutExceptionHandling();

    //     $response = $this->postJson('/api/logout');

    //     $response->assertStatus(200);
    // }
}
