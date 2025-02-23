<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Seller;
use App\Repositories\Contracts\ContactsRepositoryInterface;
use App\Repositories\Contracts\SalesRepositoryInterface;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Services\CsvLineSaverService;
use Illuminate\Database\DatabaseManager;
use Mockery;
use Tests\TestCase;

class CsvLineSaverServiceTest extends TestCase
{
    public function test_save_processes_csv_row_correctly()
    {
        $csvRow = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'amount' => 100,
        ];

        $mockSeller = new Seller;
        $mockSeller->id = 1;

        $mockContact = new Contact;
        $mockContact->id = 2;

        $databaseMock = Mockery::mock(DatabaseManager::class);
        $databaseMock->shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($callback) {
                $callback();
            });

        $sellerRepositoryMock = Mockery::mock(SellerRepositoryInterface::class);
        $contactsRepositoryMock = Mockery::mock(ContactsRepositoryInterface::class);
        $salesRepositoryMock = Mockery::mock(SalesRepositoryInterface::class);

        $sellerRepositoryMock->shouldReceive('createFromCSVLine')
            ->once()
            ->with($csvRow)
            ->andReturn($mockSeller);

        $contactsRepositoryMock->shouldReceive('createFromCSVLine')
            ->once()
            ->with($csvRow, $mockSeller->id)
            ->andReturn($mockContact);

        $salesRepositoryMock->shouldReceive('createFromCSVLine')
            ->once()
            ->with($csvRow, $mockContact->id);

        $csvLineSaverService = new CsvLineSaverService(
            $databaseMock,
            $salesRepositoryMock,
            $sellerRepositoryMock,
            $contactsRepositoryMock
        );

        $csvLineSaverService->save($csvRow);
    }
}
