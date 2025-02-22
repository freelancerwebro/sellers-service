<?php

declare(strict_types=1);

namespace App\Services\Contracts;

interface CsvLineSaverServiceInterface
{
    public function save(array $csvRow): void;
}
