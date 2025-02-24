<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSellerSalesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sellers/{id}/sales",
     *     summary="Retrieve all sales data for a seller",
     *     tags={"Sellers"},
     *     operationId="d_getSellerSales",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Seller ID",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Sales retrieved successfully",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *
     *                 @OA\Property(property="sale_id", type="integer", example=101),
     *                 @OA\Property(property="product", type="string", example="Laptop"),
     *                 @OA\Property(property="quantity", type="integer", example=2),
     *                 @OA\Property(property="total_price", type="number", format="float", example=1999.99)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Seller not found",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="error", type="string", example="Seller not found")
     *         )
     *     )
     * )
     */
    public function __invoke(
        Request $request,
        SellerServiceInterface $service
    ): JsonResponse {
        return $service->getSellerSales($request);
    }
}
