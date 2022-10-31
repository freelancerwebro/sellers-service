<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactsRepository implements ContactsRepositoryInterface
{
    public function getBySellerId(int $id): Collection
    {
        return Contact::whereSellerId($id)->get();
    }
}