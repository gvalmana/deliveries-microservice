<?php

namespace App\Providers;

use App\Adapters\Implementations\StockRequestImpl;
use App\Adapters\IStockRequestAdapter;
use App\Http\UseCases\IGetCookingOrders;
use App\Http\UseCases\IGetOrderHistory;
use App\Http\UseCases\Implementations\GetRecipesList;
use App\Http\UseCases\IGetRecipesList;
use App\Http\UseCases\Implementations\GetCookingOrders;
use App\Http\UseCases\Implementations\GetOrderHistory;
use App\Http\UseCases\IOrderStore;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Http\UseCases\Implementations\OrderStore;
use App\Http\UseCases\Implementations\SendStockIngredientsRequestTest;
use App\Http\UseCases\IOrderHistory;
use App\Models\Repositories\IFoodRecipeRepository;
use App\Models\Repositories\Implementations\FoodRecipeRepository;
use App\Models\Repositories\Implementations\OrderRepository;
use App\Models\Repositories\IOrderRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind(ISendStockIngredientsRequest::class, SendStockIngredientsRequestTest::class);
        //Repositories
        App::bind(IFoodRecipeRepository::class, FoodRecipeRepository::class);
        App::bind(IOrderRepository::class, OrderRepository::class);
        //UseCases
        App::singleton(IOrderStore::class, OrderStore::class);
        App::singleton(IStockRequestAdapter::class, StockRequestImpl::class);
        App::singleton(IGetRecipesList::class, GetRecipesList::class);
        App::singleton(IGetOrderHistory::class, GetOrderHistory::class);
        App::singleton(IGetCookingOrders::class, GetCookingOrders::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
