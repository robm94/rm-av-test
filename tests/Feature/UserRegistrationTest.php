<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $userData = [
            'email' => 'rm@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);
        $response->assertRedirect('/quotes');
        $this->assertDatabaseHas('users', ['email' => 'rm@example.com']);
    }

    public function test_user_registration_fails_when_password_confirm_invalid()
    {
        $userData = [
            'email' => 'rm@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'rm@example.com']);
    }
    
    public function test_user_registration_fails_when_email_not_unique()
    {
        User::factory()->create(['email' => 'rm@example.com']);
        
        $userData = [
            'email' => 'rm@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
}