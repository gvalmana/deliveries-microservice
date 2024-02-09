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
final class OrderCookingController extends Controller
{
    use ParamsProcessTrait;
    use HttpResponsable;
    use PaginationTrait;
    /**
     * @OA\Get(
     *     path="/api/orders/cooking",
     *     summary="Ordenes en preparación",
     *     tags={"Delivery"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de ordenes que están en preparación",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="type", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                @OA\Property(property="id", type="integer", example="1"),
     *                @OA\Property(property="code", type="string", example="2302faca-7f66-4078-86d4-abb0ab54b675"),
     *       )),
     * )
     *       )),
     *           ),
     *         )
     *     ),
     * )
     */
    public function __invoke(Request $request, IGetCookingOrders $service)
    {
        return $this->getCookingOrders($request, $service);
    }

    private function getCookingOrders(Request $request, IGetCookingOrders $service)
    {
        $params = $this->processParams($request);
        $orders = $service($params);
        $links = $this->makeMetaData($orders);
        return $this->makeResponseList(OrderResource::collection($orders), $links);
    }
}
