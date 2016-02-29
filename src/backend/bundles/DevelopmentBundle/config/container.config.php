<?php
namespace Development;

use Development\Factory\Middleware\DumpConfigMiddlewareFactory;
use Development\Factory\Service\DumpConfigServiceFactory;
use Development\Middleware\DumpConfigMiddleware;
use Development\Service\DumpConfigService;
use Development\Factory\Middleware\APIDocsMiddlewareFactory;
use Development\Factory\Service\APIDocsServiceFactory;
use Development\Middleware\APIDocsMiddleware;
use Development\Service\APIDocsService;

return [
    'zend_service_manager' => [
        'factories' => [
            DumpConfigService::class => DumpConfigServiceFactory::class,
            DumpConfigMiddleware::class => DumpConfigMiddlewareFactory::class,
            APIDocsMiddleware::class => APIDocsMiddlewareFactory::class,
            APIDocsService::class => APIDocsServiceFactory::class
        ]
    ]
];