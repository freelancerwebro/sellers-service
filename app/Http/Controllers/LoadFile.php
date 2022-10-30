<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Contracts\LoadFileServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoadFile extends Controller
{
    public function __invoke(
        Request $request,
        LoadFileServiceInterface $service
    ): JsonResponse {
        return $service->loadFile($request);
    }
}