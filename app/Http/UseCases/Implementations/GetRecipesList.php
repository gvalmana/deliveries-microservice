<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IGetRecipesList;
use App\Models\Repositories\IFoodRecipeRepository;

class GetRecipesList implements IGetRecipesList
{

    private  IFoodRecipeRepository $repository;
    public function __construct(IFoodRecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $params)
    {
        return $this->listAll($params);
    }

    public function listAll(array $params)
    {
        return $this->repository->listAll($params);
    }
}
