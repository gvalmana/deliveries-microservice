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
use App\Http\UseCases\Implementations\SendStockIngredientsHttpRequest;
use App\Http\UseCases\Implementations\SendStockIngredientsKafkaProducer;
use App\Http\UseCases\Implementations\SendStockIngredientsRequestTest;
use App\Http\UseCases\Implementations\UpdateOrderStatus;
use App\Http\UseCases\IOrderWebhookStatusUpdate;
use App\Models\Repositories\IFoodRecipeRepository;
use App\Models\Repositories\Implementations\FoodRecipeRepository;
use App\Models\Repositories\Implementations\OrderRepository;
use App\Models\Repositories\IOrderRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind(ISendStockIngredientsRequest::class, function () {
            if(config("globals.comunication_protocol") =='http'){
                return new SendStockIngredientsHttpRequest(app(IStockRequestAdapter::class), app(IOrderRepository::class));
            } elseif (config("globals.comunication_protocol") =='kafka'){
                return new SendStockIngredientsKafkaProducer();
            } else {
                return new SendStockIngredientsHttpRequest(app(IStockRequestAdapter::class), app(IOrderRepository::class));
            }
        });
        //Repositories
        App::bind(IFoodRecipeRepository::class, FoodRecipeRepository::class);
        App::bind(IOrderRepository::class, OrderRepository::class);
        //UseCases
        App::singleton(IOrderStore::class, OrderStore::class);
        App::singleton(IStockRequestAdapter::class, StockRequestImpl::class);
        App::singleton(IGetRecipesList::class, GetRecipesList::class);
        App::singleton(IGetOrderHistory::class, GetOrderHistory::class);
        App::singleton(IGetCookingOrders::class, GetCookingOrders::class);
        App::singleton(IOrderWebhookStatusUpdate::class, UpdateOrderStatus::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
