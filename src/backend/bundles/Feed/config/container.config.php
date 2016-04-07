<?php
namespace Feed;

use Feed\Factory\Middleware\FeedMiddlewareFactory;
use Feed\Factory\Service\FeedServiceFactory;
use Feed\Middleware\FeedMiddleware;
use Feed\Service\FeedService;

return [
    'zend_service_manager' => [
        'factories' => [
            FeedMiddleware::class => FeedMiddlewareFactory::class,
            FeedService::class => FeedServiceFactory::class
        ]
    ],
    'services' => [
        'SearchConfig' => [
                "maxLimit" => 150
        ],
    ]
];