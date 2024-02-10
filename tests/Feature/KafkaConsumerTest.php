<?php

namespace Tests\Feature;

use App\Http\UseCases\Implementations\UpdateOrderStatus;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\ConsumedMessage;
use Tests\TestCase;

class KafkaConsumerTest extends TestCase
{
    use RefreshDatabase;
    public function test_kafka_consumer_command()
    {
        Kafka::fake();
        $this->seed();
        $order_code = "test";
        Order::factory()->create(['status' => Order::PENDING_STATUS, 'code' => $order_code]);

        Kafka::shouldReceiveMessages([
            new ConsumedMessage(
                topicName: 'my-topic',
                partition: 0,
                headers: [],
                body: ['event' => 'update_cooking_status','data' => ['order_code' => $order_code]],
                key: null,
                offset: 0,
                timestamp: 0
            ),
        ]);

        $consumer = Kafka::createConsumer(['mark-post-as-published-topic'])
            ->withHandler(function (KafkaConsumerMessage $message) use (&$order) {
                $updater = $this->app->make(UpdateOrderStatus::class);
                $body = $message->getBody();
                $updater($body);
                return 0;
            })->build();

        $consumer->consume();
        $updatedOrder = Order::where('code', $order_code)->first();
        $this->assertEquals(Order::COOKING_STATUS, $updatedOrder->status);
        //$this->assertDatabaseHas('orders',['status'=>Order::COOKING_STATUS]);
    }
}
