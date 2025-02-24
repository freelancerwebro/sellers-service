<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoadFileRequest;
use App\Services\Contracts\LoadFileServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Sellers Service - API Documentation",
 *      description="Swagger documentation for the Sellers Service API",
 *
 *      @OA\Contact(
 *          email="sorin.marian.dev@gmail.com"
 *      )
 * )
 */
class LoadFileController extends Controller
{
    /**
     * @OA\Post(
     *     path="/load",
     *     summary="Upload a CSV file",
     *     tags={"CSV"},
     *     operationId="a_uploadCsv",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *                 required={"file"},
     *
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="CSV file to upload"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="File successfully uploaded and processed",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="File uploaded successfully")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid file or bad request",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="error", type="string", example="Invalid file format")
     *         )
     *     )
     * )
     */
    public function __invoke(
        LoadFileRequest $request,
        LoadFileServiceInterface $service
    ): JsonResponse {
        return $service->loadFile($request);
    }
}
