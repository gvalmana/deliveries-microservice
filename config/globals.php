<?php
return [
    'stock_microservice' =>[
        'url' => env('STOCK_INGREDIENTS_URL', 'http://localhost:8001/api'),
        'get_order_path' => env('STOCK_ORDERS_PATH', '/orders/get-order'),
    ],
    'comunication_protocol' => env('APP_COMUNICATION_PROTOCOL', 'http'),
    'security_key' => env('APP_SECURITY_KEY'),
];
