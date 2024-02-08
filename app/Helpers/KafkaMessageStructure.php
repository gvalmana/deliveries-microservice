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

    abstract function setTopic(string $topic);

    private function generateData()
    {
        return [
            'key' => $this->key,
            'date' => $this->date,
            'data' => $this->data
        ];
    }
}
