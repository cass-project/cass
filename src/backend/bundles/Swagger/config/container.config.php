<?php
use Common\Bootstrap\Bundle\BundleService;
use Swagger\Middleware\APIDocsMiddleware;
use Swagger\Service\APIDocsService;

use function DI\object;
use function DI\factory;
use function DI\get;

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