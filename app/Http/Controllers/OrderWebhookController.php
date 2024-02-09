<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderWebHookRequest;
use App\Http\UseCases\IOrderWebhookStatusUpdate;

class OrderWebhookController extends Controller
{
    public function __invoke(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        return $this->webhook($request, $service);
    }

    public function webhook(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        $data = $service($request->input());
        return response()->json($data);
    }
}
