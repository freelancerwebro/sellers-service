<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\ContactsRepositoryInterface;
use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Services\Contracts\CsvLineSaverServiceInterface;
use Illuminate\Support\Facades\DB;

readonly class CsvLineSaverService implements CsvLineSaverServiceInterface
{
    public function __construct(
        private SalesRepositoryInterface $salesRepository,
        private SellerRepositoryInterface $sellerRepository,
        private ContactsRepositoryInterface $contactsRepository
    ) {}

    public function save(array $csvRow): void
    {
        DB::transaction(function () use ($csvRow) {
            $seller = $this->sellerRepository->createFromCSVLine($csvRow);

            $contact = $this->contactsRepository->createFromCSVLine($csvRow, (int) $seller->id);

            $this->salesRepository->createFromCSVLine($csvRow, $contact->id);
        });
    }
}
