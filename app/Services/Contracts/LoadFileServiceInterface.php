<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Http\Requests\LoadFileRequest;
use Illuminate\Http\JsonResponse;

interface LoadFileServiceInterface
{
    public function loadFile(LoadFileRequest $request): JsonResponse;
}
