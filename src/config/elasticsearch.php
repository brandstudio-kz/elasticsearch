<?php

return [
    'hosts' => [
        "localhost:9200",
    ],
    'enabled' => env('ELASTIC_ENABLED', false),
    'cache_lifetime' => env('ELASTIC_CACHE', 1)// 60 * 10 seconds
];
