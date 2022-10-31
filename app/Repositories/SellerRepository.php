<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Seller;
use App\Repositories\Contracts\SellerRepositoryInterface;

class SellerRepository implements SellerRepositoryInterface
{
    public function getById(int $id): Seller
    {
        return Seller::whereId($id)->firstOrFail();
    }
}