<?php
namespace App\Adapters\Implementations;

use App\Adapters\BaseAdapter;
use App\Adapters\IStockRequestAdapter;

final class StockRequestImpl extends BaseAdapter implements IStockRequestAdapter
{
    public function __construct()
    {
        parent::__construct();
        $this->url = config('globals.stock_microservice.url');
    }

    public function sendStockIngredients(array $data)
    {
        $response = $this->sendPostPublicRequest($this->url.'/get-stock-ingredients', $data);
        return $response;
    }
}
