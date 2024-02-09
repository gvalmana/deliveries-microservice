<?php

use App\Http\Controllers\OrderCookingController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\OrderStoreController;
use App\Http\Controllers\OrderWebhookController;
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

Route::group(['prefix' => 'orders','middleware' => ['log.http.requests']], function () {
    Route::post('store', OrderStoreController::class)->name('orders.store');
    Route::get('/history', OrderHistoryController::class)->name('history.orders.index');
    Route::get('/cooking', OrderCookingController::class)->name('orders.get_cooking_orders');
});

Route::group(['prefix' => 'recipes','middleware' => ['log.http.requests']], function () {
    Route::get('/', RecipeListController::class)->name('recipes.index');
});

Route::group(['prefix' => 'webhooks','middleware' => ['log.http.requests']], function () {
    Route::post('orders', OrderWebhookController::class)->name('webhooks.orders')->middleware('api:check.authorization.header');
});

Route::get('/healtcheck', function() {
    return response()->json([
        'status' => true,
        'message' => 'OK, I am healthy!'
    ]);
})->name('healtcheck')->middleware('log.http.requests');
