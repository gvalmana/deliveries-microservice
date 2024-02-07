<?php

namespace App\Providers;

use App\Http\UseCases\IOrderStore;
use App\Http\UseCases\OrderStoreImpl;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::singleton(IOrderStore::class, OrderStoreImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
