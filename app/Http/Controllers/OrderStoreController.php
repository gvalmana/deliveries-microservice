<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\UseCases\IGetOrderHistory;
use App\Http\UseCases\IOrderStore;
use App\Jobs\ProcessCreatedOrderJob;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    public function store(Request $request, IOrderStore $service)
    {
        $data = $request->all();
        $order = $service->createOrder($data);
        ProcessCreatedOrderJob::dispatchAfterResponse($order);
        return response()->json([
            'status' => $order->status,
            'code' => $order->code,
        ], 200);
    }

    public function index(Request $request, IGetOrderHistory $service)
    {
        $data = $request->all();
        $orders = $service->getOrderHistory($data);
        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }
}
