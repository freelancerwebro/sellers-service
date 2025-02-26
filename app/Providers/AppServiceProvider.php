<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\ContactsRepository;
use App\Repositories\SalesRepository;
use App\Repositories\SellerRepository;
use App\Services\Contracts\CsvLineSaverServiceInterface;
use App\Services\Contracts\LoadFileServiceInterface;
use App\Services\Contracts\SellerServiceInterface;
use App\Services\CsvLineSaverService;
use App\Services\LoadFileService;
use App\Services\SellerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides()
    {
        return [
            SellerServiceInterface::class,
            LoadFileServiceInterface::class,
            CsvLineSaverServiceInterface::class,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SellerServiceInterface::class, static function (Application $app) {
            return new SellerService(
                $app->get(SalesRepository::class),
                $app->get(SellerRepository::class),
                $app->get(ContactsRepository::class)
            );
        });

        $this->app->bind(LoadFileServiceInterface::class, static function (Application $app) {
            return new LoadFileService;
        });

        $this->app->bind(CsvLineSaverServiceInterface::class, static function (Application $app) {
            return new CsvLineSaverService(
                $app->get(DatabaseManager::class),
                $app->get(SalesRepository::class),
                $app->get(SellerRepository::class),
                $app->get(ContactsRepository::class)
            );
        });
    }
}
