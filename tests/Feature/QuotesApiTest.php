<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class QuotesApiTest extends TestCase
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
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$token = null;
    }

    /**
     * Test get quotes returns 5 quotes
     */
    public function test_quotes_successful_response(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->json('GET', '/api/quotes');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }
    
    /**
     * Test get quotes is pulling from cache
     */
    public function test_get_quotes_caches_results(): void
    {
        Http::fake([
            'https://api.kanye.rest/quotes' => Http::sequence()
            ->push([1,2,3,4,5,6], 200)
            ->push([7,8,9,10,11,12], 200)
            ->pushStatus(200)
        ]);

        for ($i=0; $i < 2; $i++) { 
            $response = $this->withHeaders([
                'Authorization' => "Bearer {$this->token}",
            ])->json('GET', '/api/quotes');
            $largest = $response->collect()->max();
            $this->assertLessThanOrEqual(6, $largest);
            $smallest = $response->collect()->min();
            $this->assertGreaterThanOrEqual(1, $smallest);
        }
    }

    /**
     * Test quotes refresh return 5 quotes
     */
    public function test_quotes_refresh_successful_response(): void
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->json('GET', '/api/quotes/refresh');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    /**
     * Test refresh is not pulling from cache
     */
    public function test_quotes_refresh_retrieves_new_quotes(): void
    {
        Http::fake([
            'https://api.kanye.rest/quotes' => Http::sequence()
            ->push([1,2,3,4,5,6], 200)
            ->push([7,8,9,10,11,12], 200)
            ->pushStatus(200)
        ]);
        $maxs = [6,12];
        $mins = [1,7];

        for ($i=0; $i < 2; $i++) { 
            $response = $this->withHeaders([
                'Authorization' => "Bearer {$this->token}",
            ])->json('GET', '/api/quotes/refresh');
            $largest = $response->collect()->max();
            $this->assertLessThanOrEqual($maxs[$i], $largest);
            $smallest = $response->collect()->min();
            $this->assertGreaterThanOrEqual($mins[$i], $smallest);
        }
    }
}
