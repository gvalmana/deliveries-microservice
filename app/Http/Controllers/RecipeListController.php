<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Http\UseCases\IGetRecipesList;
use Illuminate\Http\Request;

final class RecipeListController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recipes",
     *     summary="Listado de recetas",
     *     tags={"Delivery"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de recetas",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="type", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="name", type="string", example="Ensalada de Pollo y Aguacate"),
     *                 @OA\Property(property="description", type="string", example="Una deliciosa ensalada con trozos de pollo a la parrilla, aguacate, tomate, y hojas verdes. Aderezada con una vinagreta de limón y miel."),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      required={"ingredients"},
     *                      @OA\Property(property="name", type="string", example="Tomato"),
     *                      @OA\Property(property="quantity", type="integer", example=3),
     *                  ),
     *              ),
     *          )
     *       )),
     *           ),
     *         )
     *     ),
     * )
     */
    public function __invoke(Request $request, IGetRecipesList $service)
    {
        return $this->index($request, $service);
    }

    public function index(Request $request, IGetRecipesList $service)
    {
        $data = $service($request->all());
        return response()->json(['data' => RecipeResource::collection($data)], 200);
    }
}
