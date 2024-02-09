<?php

namespace App\Http\Controllers;

use App\Http\UseCases\IOrderStore;
use App\Jobs\ProcessCreatedOrderJob;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    public function __invoke(Request $request, IOrderStore $service)
    {
        return $this->store($request, $service);
    }
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
}
