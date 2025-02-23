<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoadFileRequest;
use App\Services\Contracts\LoadFileServiceInterface;
use Illuminate\Http\JsonResponse;

class LoadFileController extends Controller
{
    public function __invoke(
        LoadFileRequest $request,
        LoadFileServiceInterface $service
    ): JsonResponse {
        return $service->loadFile($request);
    }
}
