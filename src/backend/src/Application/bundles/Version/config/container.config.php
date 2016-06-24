<?php
namespace Application\Version;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Version\Service\VersionService;

return [
    'php-di' => [
        VersionService::class => object()
            ->constructorParameter('current', get('config.version.current'))
            ->constructorParameter('frontendSPABlacklist', get('config.version.blacklist')),
    ]
];