<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\LoadFileRequest;
use App\Jobs\ProcessCsvChunk;
use App\Services\Contracts\LoadFileServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

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

        while (($row = fgetcsv($file)) !== false) {
            $chunk[] = $row;

            if (count($chunk) >= self::BATCH_SIZE) {
                ProcessCsvChunk::dispatch($chunk);
                $chunk = [];
            }
        }

        if (! empty($chunk)) {
            ProcessCsvChunk::dispatch($chunk);
        }

        fclose($file);

        return response()->json([
            'message' => 'The CSV file is valid. It\'s being processed in the background.',
        ]);
    }
}
