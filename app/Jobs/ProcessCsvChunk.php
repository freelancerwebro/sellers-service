<?php

namespace App\Jobs;

use App\Services\Contracts\CsvLineSaverServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCsvChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly array $chunk,
    ) {
    }

    public function handle(CsvLineSaverServiceInterface $csvLineSaverService)
    {
        Log::info('Processing job started.....');
        Log::info('Rows to be processed..... ', ['count' => count($this->chunk)]);

        foreach ($this->chunk as $row) {
            $csvLineSaverService->save($row);
        }
    }
}
