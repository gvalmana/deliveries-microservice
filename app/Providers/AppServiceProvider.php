<?php

namespace App\Providers;

use App\Adapters\Implementations\StockRequestImpl;
use App\Adapters\IStockRequestAdapter;
use App\Http\UseCases\Implementations\GetRecipesList;
use App\Http\UseCases\IGetRecipesList;
use App\Http\UseCases\IOrderStore;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Http\UseCases\Implementations\OrderStoreImpl;
use App\Http\UseCases\Implementations\SendStockIngredientsRequestTest;
use App\Models\Repositories\IFoodRecipeRepository;
use App\Models\Repositories\Implementations\FoodRecipeRepository;
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
        App::bind(ISendStockIngredientsRequest::class, SendStockIngredientsRequestTest::class);
        App::singleton(IStockRequestAdapter::class, StockRequestImpl::class);
        App::singleton(IGetRecipesList::class, GetRecipesList::class);
        App::bind(IFoodRecipeRepository::class, FoodRecipeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
