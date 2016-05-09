<?php
namespace Application\Frontline;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Frontline\Middleware\FrontlineMiddleware;
use Application\Frontline\Service\FrontlineService;
use Application\Service\BundleService;
use DI\Container;

return [
    'php-di' => [
        FrontlineService::class => object()->constructor(
            get(BundleService::class),
            get(Container::class)
        ),
        FrontlineMiddleware::class => object()->constructor(
            get(FrontlineService::class)
        )
    ]
];