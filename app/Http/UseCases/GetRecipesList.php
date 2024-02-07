<?php
namespace App\Http\UseCases;

use App\Models\Repositories\IFoodRecipeRepository;

class GetRecipesList implements IGetRecipesList
{

    private  IFoodRecipeRepository $repository;
    public function __construct(IFoodRecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listAll(array $params)
    {
        return $this->repository->listAll($params);
    }
}
