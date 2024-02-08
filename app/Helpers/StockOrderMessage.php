<?php
namespace App\Helpers;

class StockOrderMessage extends KafkaMessageStructure
{
    public const TOPIC = 'stock-order';

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setTopic(self::TOPIC);
        $this->setKey($data['order_id']);
    }

    public function getBody(): array
    {
        return [
            'date'=>$this->date,
            'data'=>$this->data
        ];
    }
}
