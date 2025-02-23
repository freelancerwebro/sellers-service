<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\ContactsRepositoryInterface;
use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Services\Contracts\CsvLineSaverServiceInterface;
use Illuminate\Database\DatabaseManager;
use Throwable;

readonly class CsvLineSaverService implements CsvLineSaverServiceInterface
{
    public function __construct(
        private DatabaseManager $database,
        private SalesRepositoryInterface $salesRepository,
        private SellerRepositoryInterface $sellerRepository,
        private ContactsRepositoryInterface $contactsRepository
    ) {}

    /**
     * @throws Throwable
     */
    public function save(array $csvRow): void
    {
        $this->database->transaction(function () use ($csvRow) {
            $seller = $this->sellerRepository->createFromCSVLine($csvRow);

            $contact = $this->contactsRepository->createFromCSVLine($csvRow, (int) $seller->id);

            $this->salesRepository->createFromCSVLine($csvRow, $contact->id);
        });
    }
}
