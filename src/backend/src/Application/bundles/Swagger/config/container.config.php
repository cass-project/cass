<?php
namespace Application\Swagger;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Swagger\Middleware\APIDocsMiddleware;
use Application\Swagger\Service\APIDocsService;
use Application\Service\BundleService;

return [
    'php-di' => [
        APIDocsService::class => object()->constructor(
            get(BundleService::class)
        ),
        APIDocsMiddleware::class => object()->constructor(
            get(APIDocsService::class)
        )
    ]
];