<?php

namespace App\Console\Commands;

use App\Adapters\Implementations\StockRequestImpl;
use App\Helpers\StockOrderMessage;
use App\Http\UseCases\Implementations\UpdateOrderStatus;
use App\Traits\LogAndOutputTrait;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
class KafkaConsumerCommand extends Command
{
    use LogAndOutputTrait;
    protected $signature = 'consume:stock-order-update';

    protected $description = "Consume Kafka messages from 'order-status-updated'.";

    public function handle(UpdateOrderStatus $updater)
    {
        $this->logAndOutput('Consuming messages...');
        $topics = [StockOrderMessage::TOPIC_UPDATE];
        $consumer = Kafka::createConsumer($topics)
            ->withBrokers(env('KAFKA_BROKERS'))
            ->withAutoCommit()
            ->withHandler(function(KafkaConsumerMessage $message) use ($updater){
                $this->logAndOutput($message->getKey());
                $body = $message->getBody();
                $updater($body);
            })
            ->build();
            $consumer->consume();
    }
}
