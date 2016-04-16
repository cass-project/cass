<?php
use Swagger\Factory\Middleware\APIDocsMiddlewareFactory;
use Swagger\Factory\Service\APIDocsServiceFactory;
use Swagger\Middleware\APIDocsMiddleware;
use Swagger\Service\APIDocsService;

return [
    'zend_service_manager' => [
        'factories' => [
            APIDocsMiddleware::class => APIDocsMiddlewareFactory::class,
            APIDocsService::class => APIDocsServiceFactory::class
        ]
    ]
];