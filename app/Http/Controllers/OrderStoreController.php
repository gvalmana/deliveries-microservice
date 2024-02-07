<?php

namespace App\Http\Controllers;

use App\Http\UseCases\IOrderStore;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    public function store(Request $request, IOrderStore $service)
    {
        $data = $request->all();
        $order = $service->createOrder($data);
        return response()->json([
            'status' => $order->status,
            'code' => $order->code,
        ], 200);
    }
}
