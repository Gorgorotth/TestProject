<?php
return [

    'payload_type' => env('WEBHOOK_PAYLOAD_TYPE','json'),
    'local' => [
        'endpoints' =>[
            'https://en0b3xonvuaver.x.pipedream.net',
        ],
    ],
    'production' => [
        'endpoints' =>[
            'https://webhook.site/bec98a87-f34d-4587-8a71-59e5d99b9275'
        ],

    ]
];
