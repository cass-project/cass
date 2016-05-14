<?php
namespace Application;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Service\CommandService;

return [
    'php-di' => [
        'paths' => [
            'backend' => sprintf('%s/../../../', __DIR__),
            'frontend' => sprintf('%s/../../../../frontend', __DIR__),
            'www' => sprintf('%s/../../../../www', __DIR__),
            'wwwPrefix' => '/public'
        ],
        'config.storage' => sprintf('%s/../../../../www/app/public/storage', __DIR__),
        CommandService::class => object()->constructor(
            get(Container::class)
        )
    ]
];