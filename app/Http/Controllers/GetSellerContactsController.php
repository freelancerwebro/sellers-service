<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Contracts\SellerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSellerContactsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sellers/{id}/contacts",
     *     summary="Retrieve seller's contact list",
     *     tags={"Sellers"},
     *     operationId="c_getSellerContacts",
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
     *         description="Contacts retrieved successfully",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Alice"),
     *                 @OA\Property(property="email", type="string", example="alice@example.com"),
     *                 @OA\Property(property="phone", type="string", example="+1234567890")
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
        return $service->getSellerContacts($request);
    }
}
