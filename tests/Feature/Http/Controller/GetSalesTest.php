<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use App\Models\Contact;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_sales_request_by_year_returns_correct_data()
    {
        $seller = Seller::factory()->create();
        $contact1 = Contact::factory()->create(['seller_id' => $seller->id, 'full_name' => 'John Doe', 'type' => 'Phone', 'product_type_offered_id' => 23, 'product_type_offered' => 'Product 1', 'date' => '2023-05-15']);
        $contact2 = Contact::factory()->create(['seller_id' => $seller->id, 'full_name' => 'John Doe', 'type' => 'Phone', 'product_type_offered_id' => 23, 'product_type_offered' => 'Product 1', 'date' => '2023-05-15']);
        $contact3 = Contact::factory()->create(['seller_id' => $seller->id, 'full_name' => 'John Doe', 'type' => 'Phone', 'product_type_offered_id' => 23, 'product_type_offered' => 'Product 1', 'date' => '2024-05-15']);

        $sale1 = Sale::factory()->create(['contact_id' => $contact1->id, 'net_amount' => 100, 'gross_amount' => 120, 'tax_rate' => 20, 'product_total_cost' => 10]);
        $sale2 = Sale::factory()->create(['contact_id' => $contact2->id, 'net_amount' => 200, 'gross_amount' => 220, 'tax_rate' => 20, 'product_total_cost' => 20]);
        $sale3 = Sale::factory()->create(['contact_id' => $contact2->id, 'net_amount' => 300, 'gross_amount' => 320, 'tax_rate' => 20, 'product_total_cost' => 30]);
        $sale4 = Sale::factory()->create(['contact_id' => $contact3->id, 'net_amount' => 400, 'gross_amount' => 420, 'tax_rate' => 20, 'product_total_cost' => 40]);

        $response = $this->getJson(route('getSales', ['year' => 2023]));

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'stats' => [
                    'net_amount' => 600,
                    'gross_amount' => 660,
                    'tax_amount' => 60,
                    'cost' => 60,
                    'profit' => 540,
                    'profit_percent' => 81,
                    'total_sales' => 3,
                ],
                'sales' => [
                    [
                        'id' => $sale1->id,
                        'contact_id' => $contact1->id,
                        'net_amount' => $sale1->net_amount,
                        'gross_amount' => $sale1->gross_amount,
                        'tax_rate' => $sale1->tax_rate,
                        'product_total_cost' => $sale1->product_total_cost,
                    ],
                    [
                        'id' => $sale2->id,
                        'contact_id' => $contact2->id,
                        'net_amount' => $sale2->net_amount,
                        'gross_amount' => $sale2->gross_amount,
                        'tax_rate' => $sale2->tax_rate,
                        'product_total_cost' => $sale2->product_total_cost,
                    ],
                    [
                        'id' => $sale3->id,
                        'contact_id' => $contact2->id,
                        'net_amount' => $sale3->net_amount,
                        'gross_amount' => $sale3->gross_amount,
                        'tax_rate' => $sale3->tax_rate,
                        'product_total_cost' => $sale3->product_total_cost,
                    ],
                ],
            ]]);
    }

    public function test_get_sales_request_by_year_returns_empty_array_if_no_sales_found()
    {
        $response = $this->getJson(route('getSales', ['year' => 2024]));

        $response->assertStatus(200)
            ->assertJson([]);
    }

    public function test_get_sales_by_year_returns_422_for_invalid_year()
    {
        $response = $this->getJson(route('getSales', ['year' => 'abcd'])); // Invalid year

        $response->assertStatus(422);
    }
}
