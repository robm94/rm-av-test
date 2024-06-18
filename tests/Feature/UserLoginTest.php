<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login_successful()
    {
        $data = [
            'email' => 'rm@example.com',
            'password' => 'password123'
        ];
        $user = User::factory()->create($data);

        $response = $this->post('/login', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/quotes');
        $this->assertAuthenticatedAs($user);
    }

    public function test_unregistered_user_login_fails()
    {
        $data = [
            'email' => 'notrm@example.com',
            'password' => 'password123'
        ];

        $response = $this->post('/login', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
    
    public function test_unregistered_user_logout_successful()
    {
        $data = [
            'email' => 'rm@example.com',
            'password' => 'password123'
        ];
        $user = User::factory()->create($data);

        $inResponse = $this->post('/login', $data);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/logout');
        

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
