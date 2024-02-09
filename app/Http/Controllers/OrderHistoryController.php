<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\UseCases\IGetCookingOrders;
use App\Http\UseCases\IGetOrderHistory;
use App\Models\Order;
use App\Traits\HttpResponsable;
use App\Traits\PaginationTrait;
use App\Traits\ParamsProcessTrait;
use Illuminate\Http\Request;
final class OrderHistoryController extends Controller
{
    use ParamsProcessTrait;
    use HttpResponsable;
    use PaginationTrait;

    public function __invoke(Request $request, IGetOrderHistory $service)
    {
        return $this->getOrdersHistory($request, $service);
    }
    private function getOrdersHistory(Request $request, IGetOrderHistory $service)
    {
        $params = $this->processParams($request);
        $orders = $service($params);
        $links = $this->makeMetaData($orders);
        return $this->makeResponseList(OrderResource::collection($orders), $links);
    }
}
