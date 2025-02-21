<?php

declare(strict_types=1);

namespace Tests\Feature\Job;

use App\Jobs\ProcessCsvChunk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProcessCsvChunkTest extends TestCase
{
    use RefreshDatabase;
    public function testJobIsDispatchedToQueue(): void
    {
        Queue::fake();

        $csvData = [['seller_firstname' => 'John Doe', 'seller_id' => 22]];

        ProcessCsvChunk::dispatch($csvData);

        Queue::assertPushed(ProcessCsvChunk::class);
    }

    public function testJobSavesDataToDatabase()
    {
        $this->artisan('queue:work --stop-when-empty');

        $csvData = [[
            'uuid-test',
            22,
            'John',
            'Doe',
            '2025-01-02',
            'UK',
            'London',
            '2025-01-03',
            'Tania Gilbert',
            'Phone',
            132,
            'Canned sausages',
            120,
            444,
            0.19,
            350
        ]];

        ProcessCsvChunk::dispatch($csvData);

        $this->assertDatabaseHas('sellers', [
            'id' => 22,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'date_joined' => '2025-01-02',
            'country' => 'UK'
        ]);

        $this->assertDatabaseHas('contacts', [
            'seller_id' => 22,
            'full_name' => 'Tania Gilbert',
            'region' => 'London',
            'date' => '2025-01-03',
            'type' => 'Phone',
            'product_type_offered_id' => 132,
            'product_type_offered' => 'Canned sausages',
        ]);

        $this->assertDatabaseHas('sales', [
            'net_amount' => 120,
            'gross_amount' => 444,
            'tax_rate' => 0.19,
            'product_total_cost' => 350,
        ]);
    }

    public function testJobWithEmptyCsvFile(): void
    {
        $this->artisan('queue:work --stop-when-empty');

        $csvData = [];

        ProcessCsvChunk::dispatch($csvData);

        $this->assertDatabaseCount('sellers', 0);
        $this->assertDatabaseCount('contacts', 0);
        $this->assertDatabaseCount('sales', 0);
    }
}