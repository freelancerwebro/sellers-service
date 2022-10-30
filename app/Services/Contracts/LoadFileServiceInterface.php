<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface LoadFileServiceInterface
{
    public function loadFile(Request $request): JsonResponse;
}