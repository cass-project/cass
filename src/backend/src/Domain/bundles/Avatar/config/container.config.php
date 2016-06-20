<?php
namespace Domain\Colors;

use function DI\object;
use function DI\factory;
use function DI\get;
use Domain\Avatar\Service\AvatarService;

return [
    'php-di' => [
        AvatarService::class => object()->constructorParameter('env', get('config.env')),
    ]
];