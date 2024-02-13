<?php

namespace App\Http\Controllers;

use App\Events\OrderRequested;
use App\Http\UseCases\IOrderStore;
use App\Jobs\ProcessCreatedOrderJob;
use App\Traits\HttpResponsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
* @OA\Info(title="API Delivery Microservice", version="1.0")
*
* @OA\Server(url="http://95.183.53.25:8000", description="Production Server")
* @OA\Server(url="http://localhost:8000", description="Local Server")
*/
final class OrderStoreController extends Controller
{
    use HttpResponsable;
    /**
     * @OA\Post(
     *     path="/api/orders/store",
     *     summary="Realizar orden de comida a la cocina",
     *     tags={"Delivery"},
     *     @OA\Response(
     *         response=200,
     *         description="Realizar un pedido de una comida",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="type", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="code", type="string", example="2302faca-7f66-4078-86d4-abb0ab54b675"),
     * )
     *       )),
     *           ),
     *         )
     *     ),
     * )
     */
    public function __invoke(Request $request, IOrderStore $service)
    {
        return $this->store($request, $service);
    }
    private function store(Request $request, IOrderStore $service)
    {
        $data = $request->all();
        $order = $service($data);
        //ProcessCreatedOrderJob::dispatchAfterResponse($order);
        OrderRequested::dispatch($order);
        return $this->makeResponseCreated(['code'=> $order->code], 'Order created successfully');
    }
}
