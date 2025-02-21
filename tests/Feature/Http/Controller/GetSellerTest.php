<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSellerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_seller_request_and_returns_correct_data(): void
    {
        Seller::factory()->create([
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'date_joined' => '2025-01-02',
            'country' => 'UK',
        ]);

        $response = $this->getJson(route('getSeller', ['sellerId' => 1]));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                    'date_joined' => '2025-01-02',
                    'country' => 'UK',
                ],
            ]);
    }

    public function test_get_seller_request_for_non_existing_seller()
    {
        $response = $this->getJson(route('getSeller', ['sellerId' => 999]));

        $response->assertStatus(404);
    }
}