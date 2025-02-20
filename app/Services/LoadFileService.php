<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\ProcessCsvChunk;
use App\Services\Contracts\LoadFileServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoadFileRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class LoadFileService implements LoadFileServiceInterface
{
    const BATCH_SIZE = 1000;

    /**
     * @throws Exception
     */
    public function loadFile(LoadFileRequest $request): JsonResponse
    {
        $filePath = $request->file('file')->getRealPath();
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);
        $chunk = [];

        Log::info('CSV file is being processed.....');

        while (($row = fgetcsv($file)) !== FALSE) {
            $chunk[] = $row;

            if (count($chunk) >= self::BATCH_SIZE) {
                ProcessCsvChunk::dispatch($chunk);
                $chunk = [];
            }
        }

        if (!empty($chunk)) {
            ProcessCsvChunk::dispatch($chunk);
        }

        fclose($file);

        return response()->json([
            'message' => 'The CSV file is valid. It\'s being processed in the background.',
        ]);
    }
}