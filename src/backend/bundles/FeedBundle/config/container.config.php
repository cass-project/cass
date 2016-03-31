<?php
namespace Feed;

use Feed\Factory\Middleware\FeedMiddlewareFactory;
use Feed\Middleware\FeedMiddleware;

return [
    'zend_service_manager' => [
        'factories' => [
            FeedMiddleware::class => FeedMiddlewareFactory::class
        ]
    ],
    'services' => [
        'SearchConfig' => [
                "maxLimit" => 150
        ],
    ]
];