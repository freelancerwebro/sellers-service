<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSellerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sellers/{id}",
     *     summary="Retrieve complete seller data",
     *     tags={"Sellers"},
     *     operationId="b_getSeller",
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
     *         description="Seller details retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="total_sales", type="integer", example=100)
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
        return $service->getSeller($request);
    }
}
