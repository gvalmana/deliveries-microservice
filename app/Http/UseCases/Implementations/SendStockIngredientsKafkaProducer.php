<?php
namespace App\Http\UseCases\Implementations;

use App\Helpers\StockOrderMessage;
use App\Http\UseCases\ISendStockIngredientsRequest;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
final class SendStockIngredientsKafkaProducer implements ISendStockIngredientsRequest
{
    private $configuration;

    public function __invoke(array $data)
    {
        return $this->sendStockIngredients($data);
    }

    public function sendStockIngredients(array $data)
    {
        $this->configuration = new StockOrderMessage($data);
        $message = new Message(
            body: $this->configuration->getBody(),
            key: $this->configuration->getKey(),
        );
        $publisher = Kafka::publishOn($this->configuration->getTopic())->withMessage($message);
        $publisher->send();
    }
}
