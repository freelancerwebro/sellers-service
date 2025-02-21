<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetSalesRequest;
use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;

class GetSales extends Controller
{
    public function __invoke(
        GetSalesRequest $request,
        SellerServiceInterface $service,
    ): JsonResponse {
        return $service->getSales($request);
    }
}