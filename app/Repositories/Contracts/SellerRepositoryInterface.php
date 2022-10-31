<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Seller;

interface SellerRepositoryInterface
{
    public function getById(int $id): Seller;
}