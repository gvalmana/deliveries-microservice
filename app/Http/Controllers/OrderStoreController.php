<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\UseCases\IGetOrderHistory;
use App\Http\UseCases\IOrderStore;
use App\Jobs\ProcessCreatedOrderJob;
use App\Traits\HttpResponsable;
use App\Traits\PaginationTrait;
use App\Traits\ParamsProcessTrait;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    use ParamsProcessTrait;
    use HttpResponsable;
    use PaginationTrait;
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
        $params = $this->processParams($request);
        $orders = $service->getOrderHistory($params);
        $links = null;
        $links = $this->makeMetaData($orders);
        return $this->makeResponseList(OrderResource::collection($orders), $links);
    }
}
