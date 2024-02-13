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
    protected $signature = 'consume:order-status-updated';

    protected $description = "Consume Kafka messages from 'order-status-updated'.";

    public function handle(UpdateOrderStatus $updater)
    {
        $topics = [StockOrderMessage::TOPIC_UPDATE];
        $consumer = Kafka::createConsumer($topics)
            ->withBrokers(config("kafka.brokers"))
            ->withAutoCommit()
            ->withHandler(function(KafkaConsumerMessage $message) use ($updater){
                $body = $message->getBody();
                $updater($body);
            })
            ->build();
            $consumer->consume();
    }
}
