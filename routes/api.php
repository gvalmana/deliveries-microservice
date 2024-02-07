<?php

use App\Http\Controllers\OrderListController;
use App\Http\Controllers\OrderStoreController;
use App\Http\Controllers\RecipeListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'orders'], function () {
    Route::post('store', [OrderStoreController::class, 'store'])->name('orders.store');
    Route::get('/history', [OrderListController::class, 'getOrdersHistory'])->name('history.orders.index');
    Route::get('/cooking', [OrderListController::class, 'getCookingOrders'])->name('orders.get_cooking_orders');
});

Route::group(['prefix' => 'recipes'], function () {
    Route::get('/', [RecipeListController::class, 'index'])->name('recipes.index');
});

Route::get('/healtcheck', function() {
    return response()->json([
        'status' => true,
        'message' => 'OK, I am healthy!'
    ]);
})->name('healtcheck');
