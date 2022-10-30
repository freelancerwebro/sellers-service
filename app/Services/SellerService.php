<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerService implements SellerServiceInterface
{
    public function getSeller(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'OK',
            'service' => 'SellerService',
            'method' => 'getSeller',
        ]);
    }

    public function getSellerContacts(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'OK',
            'service' => 'SellerService',
            'method' => 'getSellerContacts',
        ]);
    }

    public function getSellerSales(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'OK',
            'service' => 'SellerService',
            'method' => 'getSellerSales',
        ]);
    }

    public function getSales(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'OK',
            'service' => 'SellerService',
            'method' => 'getSales',
        ]);
    }
}