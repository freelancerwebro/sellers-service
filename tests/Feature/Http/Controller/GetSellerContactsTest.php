<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use App\Models\Contact;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSellerContactsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_seller_contacts_request_returns_correct_data()
    {
        $seller = Seller::factory()->create();
        $contact1 = Contact::factory()->create(['seller_id' => $seller->id, 'full_name' => 'John Doe', 'type' => 'Phone', 'product_type_offered_id' => 23, 'product_type_offered' => 'Product 1']);
        $contact2 = Contact::factory()->create(['seller_id' => $seller->id, 'full_name' => 'Allen Joe', 'type' => 'Email', 'product_type_offered_id' => 44, 'product_type_offered' => 'Product 2']);

        $response = $this->getJson(route('getSellerContacts', ['sellerId' => $seller->id]));

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'id' => $contact1->id,
                    'seller_id' => $seller->id,
                    'full_name' => 'John Doe',
                    'type' => 'Phone',
                    'product_type_offered_id' => 23,
                    'product_type_offered' => 'Product 1',
                ],
                [
                    'id' => $contact2->id,
                    'seller_id' => $seller->id,
                    'full_name' => 'Allen Joe',
                    'type' => 'Email',
                    'product_type_offered_id' => 44,
                    'product_type_offered' => 'Product 2',
                ],
            ]]);
    }

    public function test_get_seller_contacts_request_returns_empty_array_if_no_contacts()
    {
        $seller = Seller::factory()->create();

        $response = $this->getJson(route('getSellerContacts', ['sellerId' => $seller->id]));

        $response->assertStatus(200)
            ->assertJson([]);
    }
}
