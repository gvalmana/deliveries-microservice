<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Http\UseCases\IGetRecipesList;
use Illuminate\Http\Request;

final class RecipeListController extends Controller
{

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
