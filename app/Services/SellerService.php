<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\SellerResource;
use App\Models\Seller;
use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerService implements SellerServiceInterface
{
    public function getSeller(Request $request): JsonResponse
    {
        $id = $request->route('sellerId');
        $seller = Seller::whereId($id)->firstOrFail();

        return new JsonResponse(
            data: [
                'data' => new SellerResource($seller),
            ],
            status: Response::HTTP_OK,
        );
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