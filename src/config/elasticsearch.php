<?php

return [
    'hosts' => [
        "localhost:9200",
    ],
    'enabled' => env('ELSTIC_ENABLED', false),

    'search_params' => [
        'fuzziness' => '6',
        'fuzzy_max_expansions' => 100,
        'fuzzy_prefix_length' => 10,
        'minimum_should_match' => '0'
    ]
];
