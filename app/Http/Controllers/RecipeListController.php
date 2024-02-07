<?php

namespace App\Http\Controllers;

use App\Http\UseCases\IGetRecipesList;
use App\Models\Repositories\ListRepository;
use Illuminate\Http\Request;

class RecipeListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, IGetRecipesList $service)
    {
        $data = $service->listAll($request->all());
        return response()->json($data, 200);
    }
}
