<?php
return [
    'stock_microservice' =>[
        'url' => env('DELIVERIES_INGREDIENTS_URL', 'http://localhost:8001/api'),
        'get_order_path' => env('DELIVERIES_INGREDIENTS_WEBHOOK_ORDER_PATH', '/orders/get-order'),
    ],
    'comunication_protocol' => env('APP_COMUNICATION_PROTOCOL', 'http'),
    'security_key' => env('APP_SECURITY_KEY'),
];
