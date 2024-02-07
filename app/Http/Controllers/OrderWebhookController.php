<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderWebHookRequest;
use App\Http\UseCases\IOrderWebhookStatusUpdate;

class OrderWebhookController extends Controller
{
    public function webhook(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        $data = $service->updateOrderStatus($request->input());
        return response()->json($data);
    }
}
