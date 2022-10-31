<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Contracts\SalesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SalesRepository implements SalesRepositoryInterface
{
    public function getSalesByYear(int $year): Collection
    {
        return Sale::whereHas('contact', function ($query) use ($year) {
            $query->whereYear('date', $year);
        })->get();
    }

    public function getStatsByYear(int $year): Sale
    {
        return Sale::select(
            DB::raw("SUM(net_amount) as net_amount"),
            DB::raw("SUM(gross_amount) as gross_amount"),
            DB::raw("SUM(gross_amount - net_amount) as tax_amount"),
            DB::raw("SUM(product_total_cost) as cost"),
            DB::raw("SUM(gross_amount - (gross_amount - net_amount) - product_total_cost) as profit"),
            DB::raw("100 * SUM(gross_amount - (gross_amount - net_amount) - product_total_cost) / SUM(gross_amount) as profit_percent"),
            DB::raw('count(sales.id) as total_sales')
        )->whereHas('contact', function ($query) use ($year) {
            $query->whereYear('date', $year);
        })->first();
    }

    public function getSalesBySellerId(int $id): Collection
    {
        return Sale::whereHas('contact', function ($query) use ($id) {
            $query->where('seller_id', '=', $id);
        })->get();
    }
}