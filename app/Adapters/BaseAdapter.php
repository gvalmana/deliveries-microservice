<?php
namespace App\Adapters;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
abstract class BaseAdapter
{
    protected $headers;
    protected $url;
    public function __construct()
    {
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }
    public function sendGetPublicRequest($url, $params = null)
    {
        $response = Http::withHeaders($this->headers)
            ->retry(3, 100)
            ->timeout(15)
            ->get($url, $params);
        if ($response->clientError() || $response->serverError()) {
            return $response->object();
        }
        if ($response->ok()) {
            return $response->object();
        }
    }

    public function sendPostPublicRequest($url, $data = null)
    {
        $response = Http::withHeaders($this->headers)
            ->retry(3, 100)
            ->timeout(15)
            ->post($url, $data);
        if ($response->clientError() || $response->serverError()) {
            return $response->object();
        }
        if ($response->ok()) {
            return $response->object();
        }
    }

    public function sendPostSecuredRequest($url, $data = [])
    {
        $response = Http::withHeaders($this->headers)
            ->retry(3, 100)
            ->timeout(15)
            ->post($url, $data);
        if ($response->clientError() || $response->serverError()) {
            return $response->object();
        }
        if ($response->ok()) {
            return $response->object();
        }
    }

    public function sendGetSecuredRequest($url, $params = [])
    {
        $response = Http::withHeaders($this->headers)
            ->retry(3, 100)
            ->timeout(15)
            ->get($url, $params);
        if ($response->clientError() || $response->serverError()) {
            return $response->object();
        }
        if ($response->ok()) {
            return $response->object();
        }
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }
}
