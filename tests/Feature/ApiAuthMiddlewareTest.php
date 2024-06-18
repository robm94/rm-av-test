<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ApiAuthMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    public function setUp(): void
    {
        parent::setUp();

        if (!$this->token) {
            $user = User::factory()->create();
            $response = $this->actingAs($user)->withSession(['banned' => false])->json('GET', '/token');
            $this->token = $response->json('token');
            Auth::logout();
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$token = null;
    }

    public function test_valid_api_token_passes_auth(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->json('GET', '/api/quotes');

        $response->assertStatus(200);
    }

    public function test_missing_bearer_fails_auth(): void
    {
        $response = $this->json('GET', '/api/quotes');

        $response->assertStatus(401);
        $response->assertExactJson(['Unauthorized']);
    }

    public function test_expired_api_token_fails_auth(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer notarealtoken",
        ])->json('GET', '/api/quotes');

        $response->assertStatus(401);
        $response->assertExactJson(['Unauthorized expired']);
    }
    
    public function test_api_token_request_fails_without_user(): void
    {
        $response = $this->json('GET', '/token');

        $response->assertStatus(401);
        $response->assertExactJson(['Unauthorized']);
    }
}
