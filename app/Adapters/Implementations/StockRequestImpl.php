<?php

namespace App\Adapters\Implementations;

use App\Adapters\BaseAdapter;
use App\Adapters\IStockRequestAdapter;
use Illuminate\Support\Facades\Log;

class StockRequestImpl extends BaseAdapter implements IStockRequestAdapter
{
    public function __construct()
    {
        parent::__construct();
        $this->url = config('globals.stock_microservice.url');
    }

    public function sendStockIngredients(array $data)
    {
        $path = config('globals.stock_microservice.get_order_path');
        $this->addHeader('Authorization', 'Bearer ' . config('globals.security_key'));
        $response = $this->sendPostSecuredRequest($this->url . $path, ['data' => $data]);
        return $response;
    }
}
