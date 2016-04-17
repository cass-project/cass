<?php
use Frontline\Middleware\FrontlineMiddleware;
use Frontline\Service\FrontlineService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        FrontlineService::class => object(),
        FrontlineMiddleware::class => object()->constructor(
            get(FrontlineService::class)
        )
    ]
];