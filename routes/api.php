<?php

use App\Http\Controllers\OrderStoreController;
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
});

Route::get('/healtcheck', function() {
    return response()->json([
        'status' => true,
        'message' => 'OK, I am healthy!'
    ]);
})->name('healtcheck');
