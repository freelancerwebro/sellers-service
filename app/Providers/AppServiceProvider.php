<?php

namespace App\Providers;

use App\Domains\Internal\Contracts\Handlers\GetDomainsHandlerInterface;
use App\Domains\Internal\Handlers\GetDomainsHandler;
use App\Services\Contracts\LoadFileServiceInterface;
use App\Services\Contracts\SellerServiceInterface;
use App\Services\LoadFileService;
use App\Services\SellerService;
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
        ];
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SellerServiceInterface::class, static function () {
            return new SellerService();
        });

        $this->app->bind(LoadFileServiceInterface::class, static function () {
            return new LoadFileService();
        });
    }
}
