<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Http\Resources\SellerResource;
use App\Models\Seller;
use App\Repositories\Contracts\ContactsRepositoryInterface;
use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery;
use Tests\TestCase;

class SellerServiceTest extends TestCase
{
    public function test_get_seller_returns_seller_data_correctly()
    {
        $sellerId = 1;
        $seller = Seller::factory()->make(['id' => $sellerId]);

        Route::get('/sellers/{sellerId}', fn () => null)->name('getSeller');
        $request = Request::create(route('getSeller', ['sellerId' => $sellerId]), 'GET');
        Route::dispatch($request);

        $sellerRepositoryMock = Mockery::mock(SellerRepositoryInterface::class);
        $sellerRepositoryMock->shouldReceive('getById')
            ->once()
            ->with($sellerId)
            ->andReturn($seller);

        $salesRepositoryMock = Mockery::mock(SalesRepositoryInterface::class);
        $contactsRepositoryMock = Mockery::mock(ContactsRepositoryInterface::class);

        $sellerService = new SellerService(
            $salesRepositoryMock,
            $sellerRepositoryMock,
            $contactsRepositoryMock
        );

        $response = $sellerService->getSeller($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            (new SellerResource($seller))->response()->getData(true),
            $response->getData(true)
        );
    }
}
