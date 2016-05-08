<?php
namespace Application\Frontline;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Frontline\Middleware\FrontlineMiddleware;
use Application\Frontline\Service\FrontlineService;

return [
    'php-di' => [
        FrontlineService::class => object(),
        FrontlineMiddleware::class => object()->constructor(
            get(FrontlineService::class)
        )
    ]
];