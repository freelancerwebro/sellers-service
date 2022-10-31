<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ContactsRepositoryInterface
{
    public function getBySellerId(int $id): Collection;
}