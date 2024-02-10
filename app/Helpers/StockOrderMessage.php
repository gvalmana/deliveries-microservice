<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class StockOrderMessage extends KafkaMessageStructure
{
    public const TOPIC = 'stock-order-request';
    public const TOPIC_UPDATE = 'stock-order-update';

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setTopic(self::TOPIC);
        $this->setKey($data['order_code']);
    }

    public function getBody(): array
    {
        return [
            'date'=>$this->date,
            'data'=>$this->data
        ];
    }
}
