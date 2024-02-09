<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderWebHookRequest;
use App\Http\UseCases\IOrderWebhookStatusUpdate;
use App\Traits\HttpResponsable;

final class OrderWebhookController extends Controller
{
    use HttpResponsable;
    /**
     * @OA\Post(
     *     path="/api/webhooks/orders",
     *     summary="Actualiza una orden",
     *     tags={"Webhooks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"event","data"},
     *              @OA\Property(property="event", type="string", example="update_cooking_status"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      required={"order_code"},
     *                      @OA\Property(property="order_code", type="string", example="2302faca-7f66-4078-86d4-abb0ab54b675"),
     *                  ),
     *              ),
     *         ),
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden actualizada",
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
    public function __invoke(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        return $this->webhook($request, $service);
    }

    private function webhook(OrderWebHookRequest $request, IOrderWebhookStatusUpdate $service)
    {
        $data = $service($request->input());
        return $this->makeResponseOK([]);
    }
}
