<?php
return [
    'stock_microservice' =>[
        'url' => env('STOCK_INGREDIENTS_URL', 'http://localhost:8001/api'),
    ],
    'comomunication_protocol' => env('APP_COMUNICATION_PROTOCOL', 'http'),
    'security_key' => env('APP_SECURITY_KEY', '1234567890'),
];
