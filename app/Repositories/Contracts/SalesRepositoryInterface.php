<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

interface SalesRepositoryInterface
{
    public function getSalesByYear(int $year): Collection;
    public function getStatsByYear(int $year): Sale;
    public function getSalesBySellerId(int $id): Collection;
}