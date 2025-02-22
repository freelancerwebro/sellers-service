<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controller;

use App\Jobs\ProcessCsvChunk;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LoadFileTest extends TestCase
{
    public function test_load_request_with_valid_csv_file(): void
    {
        Queue::fake();
        Storage::fake('local');

        $csvContent = 'uuid,seller_id,seller_firstname,seller_lastname,date_joined,country,contact_region,contact_date,contact_customer_fullname,contact_type,contact_product_type_offered_id,contact_product_type_offered,sale_net_amount,sale_gross_amount,sale_tax_rate,sale_product_total_cost
8a419b28-267f-49c4-b652-d0433d20fef4,23,Hans,Müller,2018-08-17,DE,Thüringen,2021-12-04,Peter Grayson,Phone,122,Canned sausages,293.12,367.30,0.19,187.23';
        $file = UploadedFile::fake()->createWithContent('test.csv', $csvContent);

        $response = $this->postJson('/load', [
            'file' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'The CSV file is valid. It\'s being processed in the background.']);

        Queue::assertPushed(ProcessCsvChunk::class);
    }

    public function test_load_request_with_empty_csv_file(): void
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->createWithContent('test.csv', '');

        $response = $this->postJson('/load', [
            'file' => $file,
        ]);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The uploaded file is empty.']);
    }

    public function test_load_request_without_any_csv_file(): void
    {
        $response = $this->postJson('/load', [
            'file' => null,
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'The CSV file is required. (and 1 more error)']);
    }

    public function test_load_request_with_wrong_file_extension(): void
    {
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');

        $response = $this->postJson('/load', [
            'file' => $file,
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'The file must be a CSV format (.csv or .txt). (and 1 more error)']);
    }

    public function test_load_request_with_a_csv_too_large(): void
    {
        $file = UploadedFile::fake()->create('test.csv', 30000, 'text/csv');

        $response = $this->postJson('/load', [
            'file' => $file,
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'The file size must not exceed 20MB. (and 1 more error)']);
    }

    public function test_load_request_with_invalid_number_of_columns_in_csv(): void
    {
        Storage::fake('local');

        $csvContent = 'uuid,seller_id,seller_firstname
8a419b28-267f-49c4-b652-d0433d20fef4,23,Hans,Müller';
        $file = UploadedFile::fake()->createWithContent('test.csv', $csvContent);

        $response = $this->postJson('/load', [
            'file' => $file,
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'Invalid number of columns. Expected: uuid, seller_id, seller_firstname, seller_lastname, date_joined, country, contact_region, contact_date, contact_customer_fullname, contact_type, contact_product_type_offered_id, contact_product_type_offered, sale_net_amount, sale_gross_amount, sale_tax_rate, sale_product_total_cost but found 3 columns. (and 1 more error)']);
    }

    public function test_load_request_with_invalid_column_names_in_csv(): void
    {
        Storage::fake('local');

        $csvContent = 'test,seller_id,seller_firstname,seller_lastname,date_joined,country,contact_region,contact_date,contact_customer_fullname,contact_type,contact_product_type_offered_id,contact_product_type_offered,sale_net_amount,sale_gross_amount,sale_tax_rate,sale_product_total_cost
8a419b28-267f-49c4-b652-d0433d20fef4,23,Hans,Müller,2018-08-17,DE,Thüringen,2021-12-04,Peter Grayson,Phone,122,Canned sausages,293.12,367.30,0.19,187.23';
        $file = UploadedFile::fake()->createWithContent('test.csv', $csvContent);

        $response = $this->postJson('/load', [
            'file' => $file,
        ]);

        $response->assertStatus(422)
            ->assertJson(['message' => 'Invalid column names. Expected: uuid, seller_id, seller_firstname, seller_lastname, date_joined, country, contact_region, contact_date, contact_customer_fullname, contact_type, contact_product_type_offered_id, contact_product_type_offered, sale_net_amount, sale_gross_amount, sale_tax_rate, sale_product_total_cost but found: test, seller_id, seller_firstname, seller_lastname, date_joined, country, contact_region, contact_date, contact_customer_fullname, contact_type, contact_product_type_offered_id, contact_product_type_offered, sale_net_amount, sale_gross_amount, sale_tax_rate, sale_product_total_cost']);
    }
}
