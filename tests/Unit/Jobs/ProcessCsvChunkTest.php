<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessCsvChunk;
use App\Services\Contracts\CsvLineSaverServiceInterface;
use Mockery;
use Tests\TestCase;

class ProcessCsvChunkTest extends TestCase
{
    public function test_job_calls_save_method_for_each_csv_row(): void
    {
        $csvData = [
            ['name' => 'John Doe', 'amount' => 100],
            ['name' => 'Jane Doe', 'amount' => 200],
        ];

        $csvLineSaverServiceMock = Mockery::mock(CsvLineSaverServiceInterface::class);
        $csvLineSaverServiceMock->shouldReceive('save')
            ->times(2)
            ->withAnyArgs();

        $job = new ProcessCsvChunk($csvData);
        $job->handle($csvLineSaverServiceMock);
    }
}
