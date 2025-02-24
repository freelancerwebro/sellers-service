<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetSalesRequest;
use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;

class GetSalesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sales/{year}",
     *     summary="Retrieve sales statistics for a given year",
     *     tags={"Sales"},
     *     operationId="e_getSalesByYear",
     *
     *     @OA\Parameter(
     *         name="year",
     *         in="path",
     *         required=true,
     *         description="Year of sales data",
     *
     *         @OA\Schema(type="integer", example=2023)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Sales statistics retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="stats",
     *                 type="object",
     *                 @OA\Property(property="netAmount", type="number", format="float", example=100000.00),
     *                 @OA\Property(property="grossAmount", type="number", format="float", example=120000.00),
     *                 @OA\Property(property="taxAmount", type="number", format="float", example=20000.00),
     *                 @OA\Property(property="profit", type="number", format="float", example=50000.00),
     *                 @OA\Property(property="profit_percentage", type="number", format="float", example=25.0)
     *             ),
     *             @OA\Property(
     *                 property="sales",
     *                 type="array",
     *
     *                 @OA\Items(
     *
     *                     @OA\Property(property="sale_id", type="integer", example=1),
     *                     @OA\Property(property="product", type="string", example="TV"),
     *                     @OA\Property(property="quantity", type="integer", example=5),
     *                     @OA\Property(property="total_price", type="number", format="float", example=3000.00)
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid year parameter",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="error", type="string", example="Invalid year format")
     *         )
     *     )
     * )
     */
    public function __invoke(
        GetSalesRequest $request,
        SellerServiceInterface $service,
    ): JsonResponse {
        return $service->getSales($request);
    }
}
