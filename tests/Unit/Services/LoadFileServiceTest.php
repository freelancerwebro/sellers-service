<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Http\Requests\LoadFileRequest;
use App\Jobs\ProcessCsvChunk;
use App\Services\LoadFileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class LoadFileServiceTest extends TestCase
{
    public function test_load_if_processes_csv_and_dispatches_jobs()
    {
        $file = UploadedFile::fake()->create('test.csv');

        $requestMock = Mockery::mock(LoadFileRequest::class);
        $requestMock->shouldReceive('file')
            ->once()
            ->andReturn($file);

        $filePath = $file->getRealPath();
        file_put_contents($filePath, "header1,header2\nvalue1,value2\nvalue3,value4");

        Queue::fake();

        $service = new LoadFileService;

        $response = $service->loadFile($requestMock);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('The CSV file is valid. It\'s being processed in the background.', $response->getData()->message);

        Queue::assertPushed(ProcessCsvChunk::class, function ($job) {
            return count($job->getChunk()) === 2;
        });
    }
}
