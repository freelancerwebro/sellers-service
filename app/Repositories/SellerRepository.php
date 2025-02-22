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

    public function createFromCSVLine(array $csvLine): Seller
    {
        $seller = Seller::firstOrNew([
            'id' => $csvLine[1], // seller_id
        ]);
        $seller->firstname = $csvLine[2]; // seller_firstname
        $seller->lastname = $csvLine[3]; // seller_lastname
        $seller->date_joined = $csvLine[4]; // date_joined
        $seller->country = $csvLine[5]; // country
        $seller->save();

        return $seller;
    }
}
