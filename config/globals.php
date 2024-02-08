<?php
return [
    'stock_microservice' =>[
        'url' => env('STOCK_INGREDIENTS_URL', 'http://localhost:8001/api'),
    ],
    'comomunication_protocol' => env('APP_COMUNICATION_PROTOCOL', 'http'),
];
