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
     *                 @OA\Property(property="code", type="string", example="2302faca-7f66-4078-86d4-abb0ab54b675"),
     * )
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
