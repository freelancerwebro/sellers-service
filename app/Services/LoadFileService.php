<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\LoadFileServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoadFileService implements LoadFileServiceInterface
{
    public function loadFile(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'OK',
            'service' => 'LoadFileService',
            'method' => 'loadFile',
        ]);
    }
}