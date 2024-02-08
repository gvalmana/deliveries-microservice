<?php
namespace App\Helpers;

class StockOrderMessage extends KafkaMessageStructure
{
    public const TOPIC = 'stock-order';

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setTopic(self::TOPIC);
    }

    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }

}
