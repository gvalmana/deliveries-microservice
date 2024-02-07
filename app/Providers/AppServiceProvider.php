<?php

namespace App\Providers;

use App\Adapters\IStockRequestAdapter;
use App\Http\UseCases\GetRecipesList;
use App\Http\UseCases\IGetRecipesList;
use App\Http\UseCases\IOrderStore;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Http\UseCases\OrderStoreImpl;
use App\Http\UseCases\SendStockIngredientsRequestTest;
use App\Http\UseCases\StockRequestImpl;
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
