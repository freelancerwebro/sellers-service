<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use App\Models\Contact;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSellerSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_seller_sales_request_returns_correct_data()
    {
        $seller = Seller::factory()->create();
        $contact = Contact::factory()->create(['seller_id' => $seller->id]);
        $sale1 = Sale::factory()->create(['contact_id' => $contact->id, 'net_amount' => 1000, 'tax_rate' => 0.19, 'gross_amount' => 1200, 'product_total_cost' => 50]);
        $sale2 = Sale::factory()->create(['contact_id' => $contact->id, 'net_amount' => 500, 'tax_rate' => 0.19, 'gross_amount' => 700, 'product_total_cost' => 80]);
        $sale3 = Sale::factory()->create(['contact_id' => $contact->id, 'net_amount' => 800, 'tax_rate' => 0.19, 'gross_amount' => 1000, 'product_total_cost' => 120]);

        $response = $this->getJson(route('getSellerSales', ['sellerId' => $seller->id]));

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'id' => $sale1->id,
                    'contact_id' => $contact->id,
                    'net_amount' => '1000.00',
                    'tax_rate' => '0.19',
                    'gross_amount' => '1200.00',
                    'product_total_cost' => '50.00'
                ],
                [
                    'id' => $sale2->id,
                    'contact_id' => $contact->id,
                    'net_amount' => '500.00',
                    'tax_rate' => '0.19',
                    'gross_amount' => '700.00',
                    'product_total_cost' => '80.00'
                ],
                [
                    'id' => $sale3->id,
                    'contact_id' => $contact->id,
                    'net_amount' => '800.00',
                    'tax_rate' => '0.19',
                    'gross_amount' => '1000.00',
                    'product_total_cost' => '120.00'
                ]
            ]]);
    }

    public function test_get_seller_sales_request_returns_empty_array_if_no_sales()
    {
        $seller = Seller::factory()->create();

        $response = $this->getJson(route('getSellerSales', ['sellerId' => $seller->id]));

        $response->assertStatus(200)
            ->assertJson([]);
    }
}