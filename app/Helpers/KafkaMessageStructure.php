<?php
namespace App\Helpers;

use Illuminate\Support\Str;
abstract class KafkaMessageStructure
{
    protected string $topic;
    protected string $key;
    protected array $data;
    protected string $date;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->key = Str::uuid()->toString();
        $this->date = date('Y-m-d H:i:s');
    }

    private function generateData()
    {
        return [
            'key' => $this->key,
            'date' => $this->date,
            'data' => $this->data
        ];
    }

    public function getTopic(): string {
        return $this->topic;
    }

    public function setTopic(string $topic): void {
        $this->topic = $topic;
    }

    public function getKey(): string {
        return $this->key;
    }

    public function setKey(string $key): void {
        $this->key = $key;
    }

    public function getData(): array {
        return $this->data;
    }

    public function setData(array $data): void {
        $this->data = $data;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }
}
