<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderWebHookRequest;
use App\Http\UseCases\IOrderWebhookStatusUpdate;

final class OrderWebhookController extends Controller
{
    public function __invoke(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        return $this->webhook($request, $service);
    }

    private function webhook(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        $data = $service($request->input());
        return response()->json($data);
    }
}
