<?php
use Square\Middleware\CalculateSquare\CalculateSquareMiddleware;
use Square\Middleware\CalculateSquare\CalculateSquareMiddlewareFactory;
use Square\Service\Square\SquareService;
use Square\Service\Square\SquareServiceFactory;

return [
    'zend_service_manager' => [
        'factories' => [
            SquareService::class => SquareServiceFactory::class,
            CalculateSquareMiddleware::class => CalculateSquareMiddlewareFactory::class
        ]
    ]
];